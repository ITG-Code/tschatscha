<?php

class Redirect
{
  public static function to($link)
  {
    header('Location:/public' . $link);
    exit();
  }
}