<?php


class UserModel extends Model
{
    private $id;
    private $username;
    private $email;
    private $alias;
    private $firstName;
    private $surName;
    private $activated;
    private $birthDay;
    private $createdAt;
    private $changedAt;


    public function __construct(array $user = [])
    {
        parent::__construct();
        if (isset($user['id'])) {
            $this->id = $user['id'];
            $me = self::get($this->id);
            $this->username = $me->username;
            $this->email = $me->email;
            $this->alias = $me->alias;
            $this->firstName = $me->first_name;
            $this->surName = $me->sur_name;
            $this->activated = $me->activated;
            $this->birthDay = new DateTime($me->birthDay);
            $this->createdAt = new DateTime($me->created_at);
            $this->changedAt = new DateTime($me->changed_at);
        }
    }

    /**
     * Tries to log user in with the credentials given returns false on failiure true on success
     *
     * @param  string $username
     * @param  string $password
     * @return bool
     */
    public function login(string $username, string $password): bool
    {
        $stmt = self::prepare('SELECT * FROM user WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result->num_rows >= 1) {
            UserError::add(Lang::WARNING_USERNAME_EXIST_NO);
            $stmt->close();
            $result->close();
            return false;
        }
        $user = $result->fetch_object();
        if (!password_verify($password, $user->password)) {
            UserError::add(Lang::WARNING_USERNAME_PASSWORD_COMBINATION_INVALID);
            return false;
        }
        if ($user->activated == 0) {
            UserError::add(Lang::EMAIL_VERIFIED_NO);
            //TODO: Add response difference between login fail and email verification fail
            return false;
        }
        Session::set('session_user', $user->id);

        return true;
    }

    public function logout()
    {
        Session::delete('session_user');
    }

    /**
     * Checks whether the client is logged in or not
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        if (!Session::get('session_user')) {
            return false;
        }
        return self::exists(Session::get('session_user'));
    }

    /**
     * Returns the userID of a client if the client is logged in
     *
     * @return int | false
     */
    public static function getLoggedInUserId(){
        return Session::get('session_user');
    }

    public static function get(int $userid): stdClass
    {
        $stmt = self::prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if (!$result->num_rows >= 1) {
            return false;
        }
        $returnValue = $result->fetch_object();
        $result->close();
        return $returnValue;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $alias
     * @param string $firstname
     * @param string $surname
     * @param string $birthday
     * @return bool | true on success | false on failure
     * If an error is caused by the user the error message is sent to the UserError Class
     * @throws Exception | On non user related error
     */
    public static function create(
        string $username,
        string $password,
        string $email,
        string $alias,
        string $firstname,
        string $surname,
        string $birthday
    ): bool
    {
        //Removes whitespaces at the end of the strings
        $username = trim($username);
        $email = trim($email);
        $alias = trim($alias);
        $firstname = trim($firstname);
        $surname = trim($surname);
        $birthday = trim($birthday);
        $password = trim($password);

        if (self::emailExist($email)) {
            UserError::add(Lang::WARNING_EMAIL_ALREADY_IN_USE);
        }
        if (self::usernameExist($username)) {
            UserError::add(Lang::WARNING_USERNAME_ALREADY_IN_USE);
        }
        if (self::aliasExist($username)) {
            UserError::add(Lang::WARNING_ALIAS_ALREADY_IN_USE);
        }
        if (UserError::exists()) {
            return false;
        }
        $password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = self::prepare(
            "
INSERT INTO user(username, password, email, alias, first_name, sur_name, birthday)
VALUES(?,?,?,?,?,?,?)
"
        );
        $stmt->bind_param('sssssss', $username, $password, $email, $alias, $firstname, $surname, $birthday);
        if (!$stmt->execute()) {
            throw new Exception("DB: user registration failed");
        }
        $userID = $stmt->insert_id;
        $stmt->close();

        $token = bin2hex(random_bytes(128));
        $stmt = self::prepare(
            "
INSERT INTO email_confirm(user_id, token, used)
VALUES(?,?,0)
"
        );
        $stmt->bind_param('is', $userID, $token);
        $retval = $stmt->execute();
        Mailer::validateEmail($email, $username, $token);
        var_dump($stmt->error_list);
        return $retval;
    }

    public static function exists(int $userid): bool
    {
        $stmt = self::prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            $result->close();
            $stmt->close();
            return true;
        } else {
            $result->close();
            return false;
        }
    }

    public static function activate(string $token): bool
    {
        // Checks if the token is valid
        $stmt = self::prepare(
            "
SELECT * FROM email_confirm
WHERE token = ?
AND created_at = changed_at
AND used = 0
"
        );
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if (!$result->num_rows >= 1) {
            $result->close();
            UserError::add("Token not valid");
            return false;
        }

        $emailConfirm = $result->fetch_object();
        $userId = $emailConfirm->user_id;

        $stmt = self::prepare(
            "
UPDATE email_confirm
SET used = 1, changed_at = NOW()
WHERE token = ?
"
        );
        $stmt->bind_param('s', $token);
        if (!$stmt->execute()) {
            die("Something went wrong, bailing out.");
            return false;
        }
        $stmt->close();
        $stmt = self::prepare(
            "
UPDATE user
SET activated = 1
WHERE id = ?
"
        );
        $stmt->bind_param('i', $userId);
        if (!$stmt->execute()) {
            die("Something went wrong, bailing out.");
            return false;
        }
        $stmt->close();
        return true;
    }

    public static function emailExist(string $email): bool
    {
        $stmt = self::prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $alias
     * @return bool | true if the username exists, false if not
     */
    public static function aliasExist(string $alias): bool
    {
        $stmt = self::prepare("SELECT * FROM user WHERE alias = ?");
        $stmt->bind_param('s', $alias);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $username
     * @return bool | true if the username exists, false if not
     */
    public static function usernameExist(string $username): bool
    {
        $stmt = self::prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function checkInput(int $id,string $password): bool
    {
        $stmt = self::prepare("SELECT password FROM user WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        if (password_verify($password, $row->password)) {
            return true;
        } else {
            return false;
        }

    }

    public function changeAlias(int $id, string $alias)
    {
        $stmt = self::prepare("UPDATE user SET alias = ? WHERE user.id = ?");
        $stmt->bind_param('si', $alias, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function changePassword(int $id, string $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = self::prepare("UPDATE user SET password = ? WHERE user.id = ?");
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
    }

    public function changeEmail(int $id, string $email)
    {
        $stmt = self::prepare("UPDATE user SET email = ? WHERE user.id = ?");
        $stmt->bind_param('si', $email,$id);
        $stmt->execute();
    }

    public function searchForUser(string $userQuery, int $currentUser)
    {
        $stmt = self::prepare("SELECT id, CONCAT(first_name,' ','\"',alias,'\"',' ',sur_name) AS name, email FROM user WHERE id != ? AND (LCASE(CONCAT(first_name,' ',sur_name,' ',alias)) LIKE LCASE(?)  OR LCASE(email) LIKE LCASE(?))");

        $userQuery = "%$userQuery%";
        //var_dump($userQuery);
        $stmt->bind_param('iss', $currentUser, $userQuery, $userQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue = [];
        while($row = $result->fetch_object())
        {
            $returnValue[] = $row;
        }
            return $returnValue;
    }



    public function checkBlogOwnership(int $currentUser){

        $stmt = self::prepare("SELECT user_id FROM user_blog WHERE authority = 7 AND user_id = ?");
        $stmt->bind_param('i', $currentUser);
        $stmt->execute();
        var_dump($currentUser);
        }


    public function getYourBlogs(int $currentUser)
    {
        $stmt = self::prepare("SELECT blog.name, blog.url_name AS url_name, user_blog.authority AS authority, COUNT(followship.blog_id) AS followers FROM blog
INNER JOIN user_blog ON blog.id = user_blog.blog_id
INNER JOIN followship ON blog.id = followship.blog_id
WHERE user_blog.user_id = ? AND user_blog.authority >= 2 AND followship.allowed = 1
GROUP BY followship.blog_id");
        $stmt->bind_param('i', $currentUser);
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue = [];

        while($row = $result->fetch_object())
        {
            $returnValue[] = $row;
        }

        return $returnValue;
    }
    
    public function toStdClass(): stdClass
    {
        $returnValue = [
        'id' => $this->id,
        'username' => $this->username,
        'email' => $this->email,
        'alias' => $this->alias,
        'firstName' => $this->firstName,
        'surName' => $this->surName,
        'activated' => $this->activated,
        'birthDay' >= $this->birthDay,
        'createdAt' => $this->createdAt,
        'changedAt' => $this->changedAt,
        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }

    public function getUserId(int $blog_id)
    {
        $stmt = self::prepare("SELECT user_blog.user_id, user_blog.authority AS authority, user.alias AS alias FROM user_blog INNER JOIN user ON user_blog.user_id = user.id WHERE blog_id = ? AND authority < 7 GROUP BY user_id ORDER BY authority");
          $stmt->bind_param('i', $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue = [];

        while($row = $result->fetch_object())
        {
            $returnValue[] = $row;
        }

        return $returnValue;
    }

}
