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
    $stmt->close();
    if(!$result->num_rows >= 1) {
      $result->close();
      return false;
    }

    $emailConfirm = $result->fetch_object();
    $userId = $emailConfirm->user_id;

    $stmt = self::prepare("UPDATE email_confirm SET used = 1, changed_at = NOW() WHERE token = ?");
    $stmt->bind_param('s', $token);
    if(!$stmt->execute()) {
      die("Something when wrong, bailing out.");
    }
    $stmt->close();
    $stmt = self::prepare("UPDATE user SET activated = 1 WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $returnValue = $stmt->execute();
    $stmt->close();

    return $returnValue;

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

  public static function emailExist($email): bool
  {
    $stmt = self::prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 1)
      return true;
    else
      return false;
  }
  public static function aliasExist($alias): bool
  {
    $stmt = self::prepare("SELECT * FROM user WHERE alias = ?");
    $stmt->bind_param('s', $alias);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 1)
      return true;
    else
      return false;
  }
  public static function usernameExist($username): bool
  {
    $stmt = self::prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows >= 1)
      return true;
    else
      return false;

  }

}