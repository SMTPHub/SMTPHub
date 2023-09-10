<?php

namespace lib\mail;

/**
 * SMTPHub PHP SDK
 */
class SMTPHub
{
    private $api;
    private $appid;
    private $appsecret;

    /** 构造函数
     * @param string $api       接口地址，如：https://smtphub.yourcompany.com/api.php
     * @param string $appid     应用ID，如：1000
     * @param string $appsecret 应用密钥，如：Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k
     * @return void
     */
    function __construct($api, $appid, $appsecret)
    {
        $this->api       = $api;
        $this->appid     = $appid;
        $this->appsecret = $appsecret;
    }

    /** 发送邮件
     * @param string $to        收件人地址
     * @param string $subject   邮件主题
     * @param string $message   邮件内容
     * @param string $to_name   收件人名称
     * @param string $from_name 发送人名称
     * @return string|bool      是否发送成功
     */
    public function send($to, $subject, $message, $to_name, $from_name)
    {
        if (empty($this->api) || empty($this->appid) || empty($this->appsecret)) return false;
        // 构造请求参数列表
        $data = array(
            'appid'     => $this->appid,
            'appsecret' => $this->appsecret,
            'action'    => 'send',
            'to'        => $to,
            'to_name'   => $to_name,
            'subject'   => $subject,
            'message'   => $message,
            'from_name' => $from_name
        );
        $res = SMTPHub::curl_send($this->api, $data, 1);
        return $res;
    }

    private function curl_send($url, $data = null, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept: */*";
        $httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
        $httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
        $httpheader[] = "Connection: close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36 Edg/116.0.1938.62");
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

}
