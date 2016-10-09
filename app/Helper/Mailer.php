<?php

class Mailer extends MailerConfig
{

    public static function validateEmail(string $email, $username, $token) : bool
    {

        if (!isset(self::$mailer)) {
            self::initMailer();
        }
        $localMailer = self::$mailer;
        $localMailer->FromName = 'Regsitration UrbanBlog';
        $localMailer->addAddress($email, $username);
        $localMailer->isHTML = false;
        $localMailer->Subject = 'Registration UrbanBlog';
        $localMailer->Body = "
        You have registered at UrbanBlog. 
        \n\n
        Please click this link to activate your account. 
        http://localhost/register/activateaccount/$token 
        \n\n
        Thanks";

        $localMailer->AltBody = $localMailer->Body;
        if (!$localMailer->send()) {
            echo "Mailer Error: " . $localMailer->ErrorInfo;
            return false;
        } else {
            echo "Message sent!";
            echo "Please check your email for activation of your account";
            return true;
        }
    }
}
