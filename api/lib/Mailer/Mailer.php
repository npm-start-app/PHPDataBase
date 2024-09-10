<?php
namespace WBlib;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public static function create()
    {
        $mail = new PHPMailer(true);

        $mail->Mailer = "smtp";
        $mail->Host = (Settings::SSL) ? "ssl://smtp.gmail.com" : "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = Settings::gmail;
        $mail->Password = Settings::gmailPass;
        $mail->SMTPSecure = (Settings::SSL) ? 'ssl' : 'tls';
        $mail->Port = (Settings::SSL) ? 465 : 587;

        return $mail;
    }
}