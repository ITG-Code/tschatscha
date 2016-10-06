<?php


class User extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function exists(int $userid): bool{
    $stmt = self::prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('i',$userid);
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows >= 1){
      $result->close();
      return true;
    }else
      return false;
  }
  public static function login(string $username, string $password): bool{
    $stmt = self::prepare('SELECT * FROM user WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if(!$result->num_rows >= 1){
      $stmt->close();
      $result->close();
      return false;
    }
    return password_verify($password, $result->fetch_object()->password);

  }
}