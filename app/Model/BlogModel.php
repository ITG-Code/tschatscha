<?php


class BlogModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(string $blogname, string $urlname, bool $nsfw, int $currentUser_id)
    {
        $sqlblog = "INSERT INTO blog(name, url_name) VALUES(?,?)";
        $stmt = $this->prepare($sqlblog);
        $stmt->bind_param("ss", $blogname, $urlname);
        $stmt->execute();
        $id = $stmt->insert_id;
        $sqluserblog = "INSERT INTO user_blog(user_id,blog_id,authority) VALUES(?,?,7)";
        $stmtuserblog = $this->prepare($sqluserblog);
        $stmtuserblog->bind_param("ii", $currentUser_id, $id);
        $stmtuserblog->execute();
        // echo '</br>';
        // echo 'nsfw: ', $nsfw, 'blogg id=', $id;
        // echo "</br> User id:";
        // echo $currentUser_id;
        // $length = strlen($tags);
        if ($nsfw) {
          $sqlnsfw = "INSERT INTO blog_tag(blog_id,tag_id) VALUES (?,1)";
          $stmtnsfw = $this->prepare($sqlnsfw);
          $stmtnsfw->bind_param("i", $id);
          $stmtnsfw->execute();
        }
        return $id;
    }

    /**
     * Gets a list of all the blogs available
     */
    public static function list()
    {
        $result = self::query(
            "
SELECT url_name, name, alias, first_name, sur_name
FROM blog
INNER JOIN user_blog ON blog.id = user_blog.blog_id
INNER JOIN user ON user_blog.user_id = user.id
"
        );
        $returnValue = [];
        while ($object = $result->fetch_object()) {
            $returnValue[] = $object;
        }
        return $returnValue;
    }

    /**
     * @param string $blogName
     * @return bool
     */
    public static function exists(string $blogName): bool
    {
        $stmt = self::prepare('SELECT * FROM blog WHERE url_name = ?');
        $stmt->bind_param('s', $blogName);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return ($result->num_rows >= 1) ? true : false;
    }

    public static function find(string $query) : array
    {
        $stmt = self::prepare("
SELECT * FROM blog
WHERE name LIKE ?
OR url_name LIKE ?
ORDER BY name ASC
");
        $offset = URLOption::$page * URLOption::$limit;
        $query = "%$query%";
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue = [];
        while ($row = $result->fetch_object()) {
            $returnValue[] = $row;
        }
        return $returnValue;
    }

    public static function getBlogId(string $blogName)
    {
        $stmt = self::prepare("SELECT id FROM  blog  WHERE url_name = ?");
        $stmt->bind_param('s', $blogName);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->id;
        return $row;
    }


    public static function setAuthority(int $user_id, string $blogName, int $authority){
        // var_dump($user_id);
        // var_dump($blogName);
        // var_dump($authority);

        $sql = "INSERT INTO user_blog(user_id,blog_id,authority) VALUES(?,?,?)";
        $stmt = self::prepare($sql);
        $blogID = self::getBlogId($blogName);
        $stmt->bind_param("isi", $user_id, $blogID, $authority);
        $stmt->execute();
    }


    public function toStdClass(): stdClass
    {
        // TODO: Implement toStdClass() method.
        $returnValue = [

        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }

    public function follow(int $user_id, int $blog_id, string $date)
    {
        $stmt1 = self::prepare("SELECT id FROM followship WHERE user_id = ? AND blog_id = ?");
        $stmt1->bind_param('ii', $user_id, $blog_id);
        $stmt1->execute();
        $result= $stmt1->get_result();
        $stmt1->close();
        if ($result->num_rows == 0) {
            $val = 0;
            $stmt2 = self::prepare("INSERT INTO  followship (user_id,blog_id,allowed,created_at,changed_at) VALUES (?,?,?,?,?)");
            $stmt2->bind_param('iiiss', $user_id, $blog_id,$val,$date,$date);
            $stmt2->execute();
            $stmt2->close();
        }
    }
    //get people who follow you
    public function getFollowers(int $user_id)
    {
        $stmt = self::prepare("SELECT user.id, blog.id AS blog_id, user.alias AS name, blog.name AS blog_name FROM user_blog INNER JOIN followship ON user_blog.blog_id = followship.blog_id INNER JOIN user ON followship.user_id = user.id INNER JOIN blog ON followship.blog_id = blog.id WHERE user_blog.user_id = ? AND followship.allowed = 1");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result= $stmt->get_result();
        if ($result->num_rows < 0) {
            return [];
        }

        $retval = [];
        while($row = $result->fetch_object()){
            array_push($retval, $row);
        }
        return $retval;
    }

    //gets bloggs who you follow
    public function getFollows(int $user_id)
    {
        $stmt = self::prepare("SELECT followship.user_id AS id, followship.blog_id, blog.url_name, blog.name, MAX(post.changed_at) AS updated_time FROM followship INNER JOIN blog ON followship.blog_id = blog.id INNER JOIN post ON followship.blog_id = post.blog_id WHERE allowed = 1 AND followship.user_id = ? GROUP By followship.id");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result= $stmt->get_result();
        $stmt->close();
        if ($result->num_rows < 0) {
            return [];
        }

        $retval = [];
        while($row = $result->fetch_object()){
            array_push($retval, $row);
        }
        return $retval;
    }


    public function getAcceptFollowers(int $user_id)
    {
        $stmt = self::prepare("SELECT user.id, blog.id AS blog_id, user.alias AS name, blog.name AS blog_name FROM user_blog INNER JOIN followship ON user_blog.blog_id = followship.blog_id INNER JOIN user ON followship.user_id = user.id INNER JOIN blog ON followship.blog_id = blog.id WHERE user_blog.user_id = ? AND followship.allowed = 0");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result= $stmt->get_result();
        if ($result->num_rows < 0) {
            return [];
        }

        $retval = [];
        while($row = $result->fetch_object()){
            array_push($retval, $row);
        }
        return $retval;
    }

    public function acceptFollower(int $follower_id, int $blog_id)
    {        
        $stmt = self::prepare("UPDATE followship SET allowed = 1 WHERE user_id = ? AND blog_id = ?");
        $stmt->bind_param('ii', $follower_id, $blog_id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteFollower(int $follower_id, int $blog_id)
    {
        $stmt = self::prepare("DELETE FROM followship  WHERE user_id = ? AND blog_id = ?");
        $stmt->bind_param('ii', $follower_id, $blog_id);
        $stmt->execute();
        $stmt->close();
    }
    
    public function uniqueURLBlog(string $urlname)
    {
      $stmt = self::prepare("SELECT url_name FROM blog where url_name = ?");
      $stmt ->bind_param('s',$urlname);
      $stmt->execute();
      $res = $stmt->get_result();
      $stmt->close();
      var_dump($res->num_rows);
      $unique = false;
      if($res->num_rows == 0){
        $unique = true;
      }
      return $unique;

    }

    public function deleteBlog(int $blog_id){
        $stmt = self::prepare("DELETE FROM blog WHERE id = ?");
        $stmt ->bind_param('i',$blog_id);
        $stmt->execute();
        $stmt->close();
    }

}
