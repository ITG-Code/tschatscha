<?php


class UserError
{
  public static function add(string $message)
  {
    if(!Session::exists('error'))
      Session::set('error', []);
    array_push($_SESSION['error'], $message);
  }

  public static function getArray()
  {
    if(!Session::exists('error'))
      return [];

    $errors = $_SESSION['error'];
    unset($_SESSION['error']);
    return $errors;
  }

  public static function exists(): bool
  {
    return Session::exists('error');
  }
}