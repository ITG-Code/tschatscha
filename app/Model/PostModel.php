<?php

class PostModel extends Model
{
    public function __construct()

    {
        parent::__construct();
    }


    public static function createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time)
    {
        $stmt = self::prepare("INSERT INTO post(blog_id, history_id, title, url_title, content, anonymous_allowance, visibility, publishing_date, writer) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssiisi', $blog_id, $history_id, $title, $url, $content, $anon, $auth, $publishing_date, $user_id);
        $stmt->execute();
        $retval = $stmt->insert_id;
        $stmt->close();
        return $retval;
    }

    /**
     * @param $blog | if it's an int in string or int form it'll search for blog_id, else url_name
     * @param string $postName | name of a post, needs
     * @param int $limit | The max amount of posts wanted, multiple posts with same id counts as 1
     * @param int $offset |
     * @param string $search | if there's anything to search for in the title or content
     * @param bool $history | true if post history is wanted, false if not
     * @return array|stdClass array
     * @Author Brolaugh
     */
    //TODO: Fix limit and offset so that it corresponds to the documentation
    public function get($blog, string $postName = '', int $limit = 0, int $offset = 0, bool $history = false, string $search = ''):  array
    {
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
            $searchQuery = "AND (title LIKE ? OR content LIKE ?) ";
            $params[0].='ss';
            $params[] = $search;
            $params[] = $search;
        }
        $postNameQuery = '';
        if(!empty($postName)){
            $postNameQuery =  'AND url_title = ? ';
            $params[0].= 's';
            $params[] = $postName;
        }
        $params[0].='ii';
        $params[] = $limit;
        $params[] = $offset;
        $stmt = self::prepare("
            SELECT post.*, user.first_name, user.alias, user.sur_name, CONCAT_WS(', ', tag.name)
            FROM post 
            INNER JOIN blog ON post.blog_id=blog.id
            LEFT JOIN user ON post.writer=user.id
            LEFT JOIN post_tag ON post.id = post_tag.post_id
            LEFT JOIN tag ON post_tag.tag_id = tag.id
            WHERE $blogColumn = ? "
            . $history  .
            $searchQuery .
            $postNameQuery .
            "ORDER BY history_id DESC, publishing_date DESC, changed_at DESC
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
