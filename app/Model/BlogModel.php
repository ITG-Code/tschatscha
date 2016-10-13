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
        $current_id = $stmt->insert_id;
        $sqluserblog = "INSERT INTO user_blog(user_id,blog_id,authority) VALUES(?,?,7)";
        $stmtuserblog = $this->prepare($sqluserblog);
        $stmtuserblog->bind_param("ii", $currentUser_id, $current_id);
        $stmtuserblog->execute();
        // echo '</br>';
        // echo 'nsfw: ', $nsfw, 'blogg id=', $current_id;
        // echo "</br> User id:";
        // echo $currentUser_id;
        if ($nsfw) {
            $sqlnsfw = "INSERT INTO blog_tag(blog_id,tag_id) VALUES (?,1)";
            $stmtnsfw = $this->prepare($sqlnsfw);
            $stmtnsfw->bind_param("i", $current_id);
            $stmtnsfw->execute();
        }
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
        $stmt = self::prepare("SELECT id FROM `blog` WHERE url_name = ?");
        $stmt->bind_param('s', $blogName);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->id;
        return $row;
    }

    public static function setAuthority(int $user_id, int $blog_id, int $authority){
        $sql = "INSERT INTO user_blog(user_id,blog_id,authority) VALUES(?,45,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $user_id, $authority);
        $stmt->execute();

    }




//Tydligen onödig funktion
//     public static function chooseBlog(string $blogName)
//     {
//         $stmt = self::prepare("
// SELECT name AS blogName 
// FROM blog 
// INNER JOIN user_blog ON blog.id = user_blog.blog_id 
// INNER JOIN user ON user_blog.user_id = user.id 
// WHERE user_id = ? 
// AND authority = 7");
//         $stmt->bind_param("s", $blogName);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $stmt->close();
//         $returnValue = [];

//         while ($row = $result->fetch_object() >= 1) {
//             $returnValue[] = $row;
//         }
//         return $returnValue;
//     }
    public function toStdClass(): stdClass
    {
        // TODO: Implement toStdClass() method.
        $returnValue = [

        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }
}