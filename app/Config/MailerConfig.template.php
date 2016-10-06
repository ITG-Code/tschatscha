<?php


class MailerConfig
{
  protected static $mailer;
  protected static function initMailer()
  {
    self::$mailer = new PHPMailer;
    //self::$mailer->SMTPDebug = 2;
    self::$mailer->isSMTP();
    self::$mailer->Host = 'smtp.gmail.com';
    self::$mailer->SMTPAuth = true;
    self::$mailer->SMTPSecure = 'tls';
    self::$mailer->Port = 587;

    self::$mailer->Username = 'brolaughhd@gmail.com';
    self::$mailer->Password = 'supersakert';
    self::$mailer->From = 'noreply@gmail.com';
  }
}
