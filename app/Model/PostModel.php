<?php

class PostModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public static function getByName(string $name, int $blogid)
    {

        $stmt = self::prepare('SELECT * FROM post LEFT JOIN blog ON post.blog_id = blog.id WHERE post.url_title = ? AND post.blog_id = ?');
        $stmt->bind_param('si', $name,$blogid);
        $stmt->execute();
        $posts = $stmt->get_result();
        $stmt->close();
        if(!$posts->num_rows >= 1)
        {
            return false;
        }
        $returnValue = $posts->fetch_object();
        while($row = $posts->fetch_object())
        {

        }
        $posts->close();
        return $returnValue;
    }

    public static function creatPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time)
    {
        $stmt = self::prepare("INSERT INTO post(blog_id, history_id, title, url_title, content, anonymous_allowance, visibility, publishing_date, created_at, changed_at, writer) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssiisssi', $blog_id, $history_id, $title, $url, $content, $anon, $auth, $publishing_date, $time, $time, $user_id);
    }

    public static function getHistoryId()
    {
        $stmt = self::prepare("SELECT MAX(history_id) AS maxId FROM post");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->maxId;
        return $row;
    }
}

