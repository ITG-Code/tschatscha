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
}

