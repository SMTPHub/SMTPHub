<?php

namespace lib;

/**
 * email smtp （support php7）
 */
class MailSMTP
{
    /* Public Variables */
    public $smtp_host;
    public $smtp_user;
    public $smtp_pass;
    public $smtp_port;
    public $time_out;
    public $host_name;
    public $log_file;
    public $debug;
    public $auth;

    /* Private Variables */
    private $sock;

    /**
     * MailSMTP Constractor
     * @param string $smtp_host SMTP服务器
     * @param string $smtp_user 登录账号
     * @param string $smtp_pass 登录密码
     * @param int    $smtp_port SMTP服务器端口
     * @param bool   $auth      是否需要登录
     * @param bool   $debug     是否调试模式显示发送的调试信息
     * @return void
     */
    public function __construct($smtp_host, $smtp_user, $smtp_pass, $smtp_port = 25, $auth = true, $debug = false)
    {
        $this->debug = $debug;
        $this->smtp_host = $smtp_host;
        $this->smtp_user = $smtp_user;
        $this->smtp_pass = $smtp_pass;
        $this->smtp_port = $smtp_port;
        $this->auth = $auth; // auth
        $this->host_name = "localhost"; //is used in HELO command
        $this->time_out = 30; // is used in fsockopen()
        $this->log_file = "";
        $this->sock = false;
    }

    /**
     * Main Function 发送邮件
     * @param  string $from 发送人地址
     * @param  string $to 接收人地址
     * @param  string $subject 邮件主题
     * @param  string $body 邮件内容
     * @param  string $to_name 接收人名称
     * @param  string $from_name 发送人名称
     * @param  string $reply_to 回信地址
     * @param  string $reply_name 回信地址名称
     * @param  string $mailtype 邮件类型(可选 HTML / TXT, 默认 TXT)
     * @return bool   是否发送成功
     */
    public function sendmail($from, $to, $subject, $body = "", $to_name = "", $from_name = "", $mailtype = '', $cc = "", $bcc = "", $reply_to = "", $reply_name = "", $additional_headers = "")
    {
        $mail_from = $this->get_address($this->strip_comment($from));
        $body = preg_replace("/(^|(\r\n))(\.)/", "\1.\3", $body);
        $header = "MIME-Version:1.0\r\n";
        if ($mailtype == "HTML") {
            $header .= 'Content-Type: text/html; charset="utf-8"' . "\r\n";
        } else {
            $header .= 'Content-Type: text/plain; charset="utf-8"' . "\r\n";
        }
        // 接收人
        if (!empty($to_name)) {
            $header .= "To: =?utf-8?B?" . base64_encode($to_name) . "?= <{$to}>\r\n";
        } else {
            $header .= "To: {$to} <{$to}>\r\n";
        }
        // 抄送
        if (!empty($cc)) {
            $header .= "Cc: {$cc}\r\n";
        }
        // 发送人
        if (!empty($from_name)) {
            $header .= "From: =?utf-8?B?" . base64_encode($from_name) . "?= <{$from}>\r\n";
        } else {
            $header .= "From: {$from} <{$from}>\r\n";
        }
        // 回信地址
        if (!empty($reply_to)) {
            if (!empty($reply_name)) {
                $header .= "Reply-To: =?utf-8?B?" . base64_encode($reply_name) . "?= <{$reply_to}>\r\n";
            } else {
                $header .= "Reply-To: =?utf-8?B?" . base64_encode($from_name) . "?= <{$reply_to}>\r\n";
            }
        }
        $header .= "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n";
        $header .= $additional_headers;
        $header .= "Date: " . date("r") . "\r\n";
        $header .= "X-Mailer: SMTPHub v" . APP_VERSION . " (PHP/" . phpversion() . ")\r\n";
        list($msec, $sec) = explode(" ", microtime());
        $header .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $mail_from . ">\r\n";
        $TO = explode(",", $this->strip_comment($to));
        // 抄送
        if ($cc != "") {
            $TO = array_merge($TO, explode(",", $this->strip_comment($cc)));
        }
        // 密送
        if ($bcc != "") {
            $TO = array_merge($TO, explode(",", $this->strip_comment($bcc)));
        }
        // print_r($header);
        $sent = true;
        foreach ($TO as $rcpt_to) {
            $rcpt_to = $this->get_address($rcpt_to);
            if (!$this->smtp_sockopen($rcpt_to)) {
                $this->log_write("Error: Cannot send email to " . $rcpt_to . "\n");
                $sent = false;
                continue;
            }
            if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body)) {
                $this->log_write("E-mail has been sent to <" . $rcpt_to . ">\n");
            } else {
                $this->log_write("Error: Cannot send email to <" . $rcpt_to . ">\n");
                $sent = false;
            }
            fclose($this->sock);
            $this->log_write("Disconnected from remote host\n");
        }
        return $sent;
    }

    /* Private Functions */
    public function smtp_send($helo, $from, $to, $header, $body = "")
    {
        if (!$this->smtp_putcmd("HELO", $helo)) {
            return $this->smtp_error("sending HELO command");
        }
        if ($this->auth) {
            if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->smtp_user))) {
                return $this->smtp_error("sending HELO command");
            }
            if (!$this->smtp_putcmd("", base64_encode($this->smtp_pass))) {
                return $this->smtp_error("sending HELO command");
            }
        }
        if (!$this->smtp_putcmd("MAIL", "FROM:<" . $from . ">")) {
            return $this->smtp_error("sending MAIL FROM command");
        }
        if (!$this->smtp_putcmd("RCPT", "TO:<" . $to . ">")) {
            return $this->smtp_error("sending RCPT TO command");
        }
        if (!$this->smtp_putcmd("DATA")) {
            return $this->smtp_error("sending DATA command");
        }
        if (!$this->smtp_message($header, $body)) {
            return $this->smtp_error("sending message");
        }
        if (!$this->smtp_eom()) {
            return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
        }
        if (!$this->smtp_putcmd("QUIT")) {
            return $this->smtp_error("sending QUIT command");
        }
        return true;
    }

    public function smtp_sockopen($address)
    {
        if ($this->smtp_host == "") {
            return $this->smtp_sockopen_mx($address);
        } else {
            return $this->smtp_sockopen_relay();
        }
    }

    public function smtp_sockopen_relay()
    {
        $this->log_write("Trying to " . $this->smtp_host . ":" . $this->smtp_port . "\n");
        $this->sock = @fsockopen($this->smtp_host, $this->smtp_port, $errno, $errstr, $this->time_out);
        if (!($this->sock && $this->smtp_ok())) {
            $this->log_write("Error: Cannot connenct to relay host " . $this->smtp_host . "\n");
            $this->log_write("Error: " . $errstr . " (" . $errno . ")\n");
            return false;
        }
        $this->log_write("Connected to relay host " . $this->smtp_host . "\n");
        return true;
    }

    public function smtp_sockopen_mx($address)
    {
        $domain = preg_replace("/^.+@([^@]+)$/", "\1", $address);
        if (!@getmxrr($domain, $MXHOSTS)) {
            $this->log_write("Error: Cannot resolve MX \"" . $domain . "\"\n");
            return false;
        }
        foreach ($MXHOSTS as $host) {
            $this->log_write("Trying to " . $host . ":" . $this->smtp_port . "\n");
            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);
            if (!($this->sock && $this->smtp_ok())) {
                $this->log_write("Warning: Cannot connect to mx host " . $host . "\n");
                $this->log_write("Error: " . $errstr . " (" . $errno . ")\n");
                continue;
            }
            $this->log_write("Connected to mx host " . $host . "\n");
            return true;
        }
        $this->log_write("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")\n");
        return false;
    }

    public function smtp_message($header, $body)
    {
        fputs($this->sock, $header . "\r\n" . $body);
        $this->smtp_debug("> " . str_replace("\r\n", "\n" . "> ", $header . "\n> " . $body . "\n> "));
        return true;
    }

    public function smtp_eom()
    {
        fputs($this->sock, "\r\n.\r\n");
        $this->smtp_debug(". [EOM]\n");
        return $this->smtp_ok();
    }

    public function smtp_ok()
    {
        $response = str_replace("\r\n", "", fgets($this->sock, 512));
        $this->smtp_debug($response . "\n");
        if (!preg_match("/^[23]/", $response)) {
            fputs($this->sock, "QUIT\r\n");
            fgets($this->sock, 512);
            $this->log_write("Error: Remote host returned \"" . $response . "\"\n");
            return false;
        }
        return true;
    }

    public function smtp_putcmd($cmd, $arg = "")
    {
        if ($arg != "") {
            if ($cmd == "") {
                $cmd = $arg;
            } else {
                $cmd = $cmd . " " . $arg;
            }
        }
        fputs($this->sock, $cmd . "\r\n");
        $this->smtp_debug("> " . $cmd . "\n");
        return $this->smtp_ok();
    }

    public function smtp_error($string)
    {
        $this->log_write("Error: Error occurred while " . $string . ".\n");
        return false;
    }

    public function log_write($message)
    {
        $this->smtp_debug($message);
        if ($this->log_file == "") {
            return true;
        }
        $message = date("M d H:i:s ") . get_current_user() . "[" . getmypid() . "]: " . $message;
        if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {
            $this->smtp_debug("Warning: Cannot open log file \"" . $this->log_file . "\"\n");
            return false;
        }
        flock($fp, LOCK_EX);
        fputs($fp, $message);
        fclose($fp);
        return true;
    }

    public function strip_comment($address)
    {
        $comment = "/\([^()]*\)/";
        while (preg_match($comment, $address)) {
            $address = preg_replace($comment, "", $address);
        }
        return $address;
    }

    public function get_address($address)
    {
        $address = preg_replace("/([ \t\r\n])+/", "", $address);
        $address = preg_replace("/^.*<(.+)>.*$/", "\1", $address);
        return $address;
    }

    public function smtp_debug($message)
    {
        if ($this->debug) {
            echo $message;
        }
    }
}
