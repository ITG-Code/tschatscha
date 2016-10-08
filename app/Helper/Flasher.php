<?php


class Flasher
{
  public static function addError(string $message)
  {
    if(!Session::exists('error'))
      Session::set('error', []);
    array_push($_SESSION['error'], $message);
  }

  public static function getErrorArray()
  {
    if(!Session::exists('error'))
      return [];

    $errors = $_SESSION['error'];
    unset($_SESSION['error']);
    return $errors;
  }
  public static function errorsExist(): bool{
    return Session::exists('error');
  }
}