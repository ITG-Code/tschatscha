<?php


class User extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function exists(int $userid): bool
  {
    $stmt = self::prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('i', $userid);
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows >= 1) {
      $result->close();
      return true;
    } else
      return false;
  }

  public function activate(string $token): bool
  {
    // Checks if the token is valid
    $stmt = self::prepare("SELECT * FROM email_confirm 
WHERE token = ? AND created_at = changed_at AND used = 0");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if(!$result->num_rows >= 1) {
      return false;
    }
    $emailConfirm = $result->fetch_object();
    $userId = $emailConfirm->user_id;

    $stmt = self::prepare("UPDATE email_confirm SET ");

  }

  public static function login(string $username, string $password): bool
  {
    $stmt = self::prepare('SELECT * FROM user WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if(!$result->num_rows >= 1) {
      $stmt->close();
      $result->close();
      return false;
    }
    return password_verify($password, $result->fetch_object()->password);
  }

  public static function create($username, $password, $email, $alias, $firstname, $surname, $birthday)
  {
    if(self::emailExist($username) == 1 && self::usernameExist($email) == 1) {
      $SQL = "INSERT INTO 
user (username,password,email,alias,firstname,surname,birthday) 
VALUES('$username','$password','$email','$alias','$firstname','$surname','$birthday')";
      $result = self::query($SQL);
    } else {
      echo "Erororororor";
    }
  }

  public static function emailExist($email)
  {
    $SQL = "SELECT email FROM user WHERE email = \"$email\"";
    $result = self::query($SQL);
    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo "Success";

    } else {
      echo "Ett konto finns redan på den här email-adressen.";
    }
  }

  public static function usernameExist($username)
  {
    $SQL = "SELECT username FROM user WHERE username = '$username'";
    $result = self::query($SQL);
    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo "Success";

    } else {
      echo "Användarnamnet finns redan.";
    }
  }

}