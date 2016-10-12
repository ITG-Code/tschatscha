<?php

class PostModel extends Model
{
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

    public static function creatPost()
    {
        
    }
}

