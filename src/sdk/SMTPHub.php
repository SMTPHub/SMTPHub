<?php

namespace lib\mail;

class SMTPHub
{
    private $appid;
    private $appsecret;

    function __construct($appid, $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }
    public function send($to, $subject, $message, $to_name, $from_name)
    {
        if (empty($this->appid) || empty($this->appsecret)) return false;
        $url = 'https://smtphub.yourdomain.com/api.php';
        $data = array(
            'appid' => $this->appid,
            'appsecret' => $this->appsecret,
            'action' => 'send',
            'to' => $to,
            'subject' => $subject,
            'message' => $message,
            'to_name' => $to_name,
            'from_name' => $from_name
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, true);
        if ($arr['code'] == 0) {
            return true;
        } else {
            return $arr['msg'];
        }
    }
}
