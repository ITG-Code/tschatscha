<?php

class Mailer extends MailerConfig
{

  public static function validateEmail(string $email, $username, $token)
  {

    if(!isset(self::$mailer))
      self::initMailer();
    $localMailer = self::$mailer;
    $localMailer->FromName = 'Regsitration UrbanBlog';
    $localMailer->addAddress($email, $username);
    $localMailer->isHTML = false;
    $localMailer->Subject = 'Registration UrbanBlog';
    $localMailer->Body = "You have registered at UrbanBlog. \n\nPlease click this link to activate your account.\n\nThanks";
    $localMailer->AltBody = $localMailer->Body;
    if(!$localMailer->send()) {

      echo "Mailer Error: " . $localMailer->ErrorInfo;
    } else {
      echo "Message sent!";
    }
  }
}
