<?php


class UserModel extends Model
{
  private $id;
  private $username;
  private $email;
  private $alias;
  private $firstName;
  private $surName;
  private $birthDay;
  private $createdAt;
  private $changedAt;


  public function __construct(int $userID = NULL)
  {
    parent::__construct();
    if(isset($userID)) {
      $this->id = $userID;
      $me = self::get($this->id);
      $this->username = $me->username;
      $this->email = $me->email;
      $this->alias = $me->alias;
      $this->firstName = $me->first_name;
      $this->surName = $me->sur_name;
      $this->birthDay = new DateTime($me->birthDay);
      $this->createdAt = new DateTime($me->created_at);
      $this->changedAt = new DateTime($me->changed_at);
    }
  }

  /**
   * Tries to log user in with the credentials given returns false on failiure true on success
   * @param string $username
   * @param string $password
   * @return bool
   */
  public function login(string $username, string $password): bool
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
    if(!password_verify($password, $result->fetch_object()->password)) {
      return false;
    }
    Session::set('session_user', $result->fetch_object()->id);
    return true;
  }

  public static function isLoggedIn(): bool
  {
    if(!Session::get('session_user')) {
      return false;
    }
    return self::exists(Session::get('session_user'));
  }

  public static function get(int $userid)
  {
    $stmt = self::prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows >= 1) {
      return false;
    }
    $returnValue = $result->fetch_object();
    $result->close();
    return $returnValue;
  }

  public static function create(string $username, string $password, string $email, string $alias, string $firstname, string $surname, $birthday)
  {
    //Removes whitespaces at the end of the strings
    $username = trim($username);
    $email = trim($email);
    $alias = trim($alias);
    $firstname = trim($firstname);
    $surname = trim($surname);
    $birthday = trim($birthday);
    $password = trim($password);

    if(self::emailExist($email)) {
      //TODO: Add error that tells email already exists
      return false;
    }
    if(self::usernameExist($username)) {
      //TODO: Add error that tells username already exists
      return false;
    }
    if(self::aliasExist($username)) {
      //TODO: Add error that tells alias already exists
      return false;
    }
    $password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = self::prepare("INSERT INTO user(username, password, email, alias, first_name, sur_name, birthday) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssss', $username, $password, $email, $alias, $firstname, $surname, $birthday);
    $retval = $stmt->execute();
    $stmt->close();
    return $retval;
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

  public static function activate(string $token): bool
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