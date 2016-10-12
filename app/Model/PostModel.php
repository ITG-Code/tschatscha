<?php

class PostModel extends Model
{
    public function __construct()

    {
        parent::__construct();
    }
    public static function getByName()
    {
        $stmt = self::prepare('SELECT * FROM post LEFT JOIN blog ON post.blog_id = blog.id WHERE post.blog_id = 2');
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

    public function toStdClass(): stdClass
    {
        // TODO: Implement toStdClass() method.
        $returnValue = [

        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }
}

