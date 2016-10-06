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
    $SQL = "INSERT INTO user (username,password,email,alias,firstname,surname,birthday) VALUES('$username','$password','$email','$alias','$firstname','$surname','$birthday')";
    $result = self::query($SQL);
  }
  public static function emailExist($email){
    $SQL = "SELECT email FROM user WHERE email = '$email'";
    $result = self::query($SQL);
    if($result->num_rows > 0){
      $row = $result -> fetch_assoc();
      echo "Success";

    }else{
      echo "Ett konto finns redan på den här email-adressen.";
    }
  }
  public static function usernameExist($username){

  }
  public static function passwordCheck($password){

  }
}