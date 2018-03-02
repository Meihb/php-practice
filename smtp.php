<?php

/**
 * Created by PhpStorm.
 * User: slyvanas_mhb
 * Date: 2017-9-19
 * Time: 9:37
 */
class smtp_mail
{
    private $host;
    private $port;
    private $user;
    private $pass;
    private $debug = false;
    private $sock;
    private $mail_format;//0普通文本;1html邮件

    function __construct($host, $port, $user, $pass, $format = true, $debug = false)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = base64_encode($user);
        $this->pass = base64_encode($pass);
        $this->debug = $debug;
        $this->mail_format = $format;

        $this->sock = fsockopen($this->host, $this->port, $error, $errorstr, 10);

        if (!$this->sock) {
            exit("Error number:$error,Errormsg:$errorstr");
        }
        $response = fgets($this->sock);
        if (strstr($response, "220") === false) {
            exit("server error:$response");
        }
    }

    private function show_debug($message)
    {
        if ($this->debug) {
            echo "<p>DEBUG:$message</p>\r\n";
        }
    }

    private function do_command($cmd, $return_code)
    {
        fwrite($this->sock, $cmd);
        $response = fgets($this->sock);
        if (strstr($response, "$return_code") === false) {
            $this->show_debug("retun_code should be ".$return_code.'while response is '.$response);
            return false;
        }
        return true;
    }

    private function is_mail($email)
    {
        $pattern = "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/";
        if (preg_match($pattern, $email, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    public function send_email($from, $to, $subject, $body)
    {
        if (!$this->is_mail($from) || !$this->is_mail($to)) {
            $this->show_debug("Please enter valid from/to email.");
            return false;
        }
        if (empty($subject) or empty($body)) {
            $this->show_debug("Please enter valid subject/body.");
            return false;
        }
        $detail = "From:" . $from . "\r\n";
        $detail .= "To:" . $to . "\r\n";
        $detail .= "Subject:" . $subject . "\r\n";

        if ($this->mail_format == 1) {
            $detail .= "Content-Type:text/html;\r\n";
        } else {
            $detail .= "Content-Type:text/plain;\r\n";
        }
        $detail .= "charset=gb2312\r\n\r\n";
        $detail .= $body;

        $this->do_command("HELO smtp.qq.com\r\n", 250);
        $this->do_command("AUTH LOGIN\r\n", 334);
        $this->do_command($this->user . "\r\n", 334);
        $this->do_command($this->pass . "\r\n", 235);
        $this->do_command("MAIL FROM <" . $from . ">\r\n", 250);
        $this->do_command("RCPT TO:<" . $to . ">\r\n", 250);
        $this->do_command("DATA\r\n", 354);
        $this->do_command($detail . "\r\n.\r\n", 250);
        $this->do_command("QUIT\r\n", 221);
        return true;
    }

}

$host= 'smtp.exmail.qq.com';
$port = 25;
$user = 'meihaibo@aiyintech.com';
$pass = 'Mhb12121992';
$from = 'meihaibo@aiyintech.com';
$to = '1253880904@qq.com';
$subject = 'Hello World';
$content = 'This is example email for you ';

$mail = new smtp_mail($host,$port,$user,$pass,true,true);
$mail->send_email($from,$to,$subject,$content);