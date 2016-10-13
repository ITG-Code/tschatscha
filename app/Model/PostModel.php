<?php

class PostModel extends Model
{
    public function __construct()

    {
        parent::__construct();
    }
    public static function getByName()
    {
        $stmt = self::prepare('SELECT * FROM post LEFT JOIN blog ON post.blog_id = blog.id WHERE post.blog_id = 2 AND post.history_id = 3 ORDER BY post.id DESC LIMIT 1 ');
        $stmt->execute();
        $posts = $stmt->get_result();
        if($posts->num_rows >= 1)
        {
            $returnValue = [];
            while($row = $posts->fetch_object())
            {
                $returnValue[] = $row;
            }
            return $returnValue;
        } else{
            return false;
        }
        $stmt->close();
    }

    public static function createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time)
    {
        $stmt = self::prepare("INSERT INTO post(blog_id, history_id, title, url_title, content, anonymous_allowance, visibility, publishing_date, created_at, changed_at, writer) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssiisssi', $blog_id, $history_id, $title, $url, $content, $anon, $auth, $publishing_date, $time, $time, $user_id);
        $stmt->execute();
        $retval = $stmt->insert_id;
        $stmt->close();
        return $retval;
    }

    public static function getHistoryId($url)
    {
        $stmt = self::prepare("SELECT MAX(history_id) AS maxId FROM post WHERE url_title != ?");
        $stmt->bind_param('s',$url);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->maxId;
        return $row+1;
    }

    public static function checkAuth(int $blog_id, int $user_id)
    {
        $stmt = self::prepare("SELECT authority FROM user_blog WHERE user_id = ? AND blog_id = ?");
        $stmt->bind_param('ii',$user_id,$blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows > 0){
        $row = $result->fetch_object()->authority;
        }
        else{
           $row = 0;
        }
        return $row;
    }
    public static function checkURL(string $url, int $blog_id)
    {
      $stmt = self::prepare("SELECT url_title FROM post WHERE blog_id = ? AND url_title = ?");
      $stmt->bind_param('is',$blog_id,$url_title);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      if($result->num_rows > 0){
        $unique = false;
      }
      else{
         $unique = true;
      }
      return $unique;
    }
    public function toStdClass(): stdClass
    {
        // TODO: Implement toStdClass() method.
        $returnValue = [

        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }
}
