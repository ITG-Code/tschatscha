<?php


class User extends Model
{
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

  public static function create($username,$password,$email,$alias,$firstname,$surname,$birthday){
    
  }
}