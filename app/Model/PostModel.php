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
        if (!$posts->num_rows >= 1) {
            return false;
        }
        $returnValue = [];
        while ($row = $posts->fetch_object()) {
            $returnValue[] = $row;
        }
        $stmt->close();
        return $returnValue;

    }

    public static function createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time)
    {
        $stmt = self::prepare("INSERT INTO post(blog_id, history_id, title, url_title, content, anonymous_allowance, visibility, publishing_date, writer) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssiisi', $blog_id, $history_id, $title, $url, $content, $anon, $auth, $publishing_date, $user_id);
        $stmt->execute();
    }

    /**
     * @param $blog | if it's an int in string or int form it'll search for blog_id, else url_name
     * @param int $limit | The max amount of posts wanted, multiple posts with same id counts as 1
     * @param int $offset |
     * @param string $search | if there's anything to search for in the title or content
     * @param bool $history | true if post history is wanted, false if not
     * @return stdClass array
     */
    public function get($blog, int $limit = 0, int $offset = 0, string $search = '', $history = false):  array
    {
        $blogColumn = '';
        $params = [''];
        if (is_numeric($blog) && $blog % 1 == 0) {
            $params[0].= 'i';
            $blogColumn = 'blog.blog_id';
        } else {
            $params[0].= 's';
            $blogColumn = 'blog.url_name';
        }
        $params[] = $blog;
        if ($limit <= 0) {
            $limit = URLOption::$limit;
        }
        if ($offset <= 0) {
            $offset = 0;
        }
        if(!$history){
            $history = "AND post.id IN ( SELECT MAX(id) FROM post GROUP BY history_id)";
        }else{
            $history = '';
        }
        $searchQuery = '';
        if(!empty($search)){
            $search = "%$search%";
            $searchQuery = "AND (title LIKE ? OR content LIKE ?)";
            $params[0].='ss';
            $params[] = $search;
            $params[] = $search;
        }
        $params[0].='ii';
        $params[] = $limit;
        $params[] = $offset;
        $stmt = self::prepare("
            SELECT post.* 
            FROM post 
            INNER JOIN blog ON post.blog_id=blog.id 
            WHERE $blogColumn = ? "
            . $history  .
            $searchQuery .
            "ORDER BY history_id, publishing_date, changed_at 
            LIMIT ? 
            OFFSET ?");
        $ref    = new ReflectionClass('mysqli_stmt');
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($stmt,$this->makeValuesReferenced($params));
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue= [];
        while($row = $result->fetch_object()){
            $returnValue[] = $row;
        }
        return $returnValue;
    }

    public static function getHistoryId($url)
    {
        $stmt = self::prepare("SELECT MAX(history_id) AS maxId FROM post WHERE url_title != ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->maxId;
        return $row + 1;
    }

    public static function checkAuth(int $blog_id, int $user_id)
    {
        $stmt = self::prepare("SELECT authority FROM user_blog WHERE user_id = ? AND blog_id = ?");
        $stmt->bind_param('ii', $user_id, $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_object()->authority;
        return $row;
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
