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

    public static function createComment($post_id, $content, $session_user, $created_at)
    {
        $insert = self::prepare("INSERT INTO comment(post_id, content, session_user, created_at) VALUES (?, ?, ?, ?)");
        $insert->bind_param('isis', $post_id, $content, $session_user, $created_at);
        $insert->execute();
        $insert->close();
        return $insert;
    }
    public function censorComment(int $comment_id,string $censorComment, int $auth)
    {
      if($auth < Authority::BLOG_MODERATE){
        return;
      }
      $stmt = self::prepare("UPDATE comment SET content=? where id=?");
      $stmt->bind_param('si',$censorComment,$comment_id);
      $stmt->execute();
      $stmt->close();
      return;
    }

    public static function getComments(string $anonymcommenter, int $post_id)
    {
        //kanske funkar, kanske inte, vet inte vart kommentarer finns att testa med.
        $stmt = self::prepare("SELECT comment.id as id, comment.parent_id,comment.post_id as postid,
           comment.content, session.id as sessionid, COALESCE(concat(user.first_name,' ' , '\"', user.alias, '\"', ' ' ,
             user.sur_name),?) as name, comment.created_at, comment.changed_at FROM comment
             LEFT JOIN session on comment.session_user = session.user_id LEFT JOIN user on user_id = user.id WHERE comment.post_id = ? GROUP BY comment.id");
        $stmt->bind_param('si', $anonymcommenter, $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue= [];
        while ($row = $result->fetch_object()) {
            $returnValue[] = $row;
        }
        return $returnValue;
    }

    public static function getSession($session_value, $user_id, $ip, $created_at)
    {
        $insert = self::prepare("INSERT INTO session(session_value, user_id, ip, created_at) VALUES (?, ?, ?, ?)");
        $insert->bind_param('siss', $session_value, $user_id, $ip, $created_at);
        $insert->execute();
        $insert->close();
        return $insert;
    }

    /**
     * @param string | int  $blog | if it's an int in string or int form it'll search for blog_id, else url_name
     * @param string | int  $post | if it's an int in string or int form it'll search for post_id, else url_title
     * @param int $limit | The max amount of posts wanted, multiple posts with same id counts as 1
     * @param int $offset |
     * @param string $search | if there's anything to search for in the title or content
     * @param bool $history | true if post history is wanted, false if not
     * @return array|stdClass array
     * @Author Brolaugh
     */
    //TODO: Fix limit and offset so that it corresponds to the documentation
    public function get($blog, $post = '', int $limit = 0, int $offset = 0, bool $history = false, string $search = ''):  array
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
        $groupByColumn = 'id';
        if (!$history) {
            $history = "AND post.id IN ( SELECT MAX(id) FROM post GROUP BY history_id)";
            $groupByColumn = 'history_id';
        } else {
            $history = '';
        }
        $searchQuery = '';
        if (!empty($search)) {
            $search = "%$search%";
            $searchQuery = "AND (title LIKE ? OR content LIKE ?) ";
            $params[0].='ss';
            $params[] = $search;
            $params[] = $search;
        }
        $postNameQuery = '';
        if (!empty($post) && is_string($post)) {
            $postNameQuery =  'AND url_title = ? ';
            $params[0].= 's';
            $params[] = $post;
        } elseif (!empty($post) && is_numeric($post)) {
            $postNameQuery =  'AND post.id = ? ';
            $params[0].= 'i';
            $params[] = $post;
        }
        $params[0].='ii';
        $params[] = $limit;
        $params[] = $offset;
        $stmt = self::prepare("
            SELECT post.*, user.first_name, user.alias, user.sur_name, GROUP_CONCAT(tag.name) as tags
            FROM post
            INNER JOIN blog ON post.blog_id=blog.id
            LEFT JOIN user ON post.writer=user.id
            LEFT JOIN post_tag ON post.id = post_tag.post_id
            LEFT JOIN tag ON post_tag.tag_id = tag.id
            WHERE $blogColumn = ? "
            . $history  .
            $searchQuery .
            $postNameQuery .
            "GROUP BY ".$groupByColumn." ORDER BY history_id DESC, publishing_date DESC, changed_at DESC
            LIMIT ?
            OFFSET ?");
        $ref    = new ReflectionClass('mysqli_stmt');
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($stmt, $this->makeValuesReferenced($params));
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue= [];
        while ($row = $result->fetch_object()) {
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
        if ($result->num_rows > 0) {
            $row = $result->fetch_object()->authority;
        } else {
            $row = 0;
        }
        return $row;
    }
    //In = Title,url,blogname. out= titel,url/error replaced ' ' with '-'.
    public static function checkURL(string $url_title, string $blogname, int $blog_id)
    {
        $url_title = str_replace(' ', '-', $url_title);
        $stmt = self::prepare("SELECT url_title FROM post WHERE blog_id = ? AND url_title = ?");
        $stmt->bind_param('is', $blog_id, $url_title);
      // var_dump($blog_id,$url_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $unique = false;
      // var_dump($result->num_rows);
        if ($result->num_rows == 0) {
            $unique = true;
        }
        if ($unique == false) {
            UserError::add(Lang::FORM_POST_URL_NOT_UNIQUE);
            Redirect::to('/'.$blogname.'/compose');
        }
        if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-]+$/", $url_title)) {
            UserError::add(Lang::FORM_POST_URL_INVALID_CHARS);
            Redirect::to('/'.$blogname.'/compose');
        }
        return $url_title;
    }


    public function toStdClass(): stdClass
    {
        // TODO: Implement toStdClass() method.
        $returnValue = [

        ];
        $returnValue = (object)$returnValue;
        return $returnValue;
    }

    public function deletePost(int $post_id, int $user_id)
    {

        $stmt1 = self::prepare("SELECT user_blog.authority, post.id FROM user_blog INNER JOIN post ON user_blog.blog_id = post.blog_id WHERE user_blog.user_id = ? AND post.id = ?");
        $stmt1->bind_param('ii', $user_id, $post_id);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $stmt1->close();
        if ($result->num_rows > 0) {
            $history_id = self::getHistoryPost($post_id);
            $stmt2 = self::prepare("DELETE FROM post WHERE history_id = ?");
            $stmt2->bind_param('i', $history_id);
            $stmt2->execute();
            $stmt2->close();
        }
    }
    /*
    * In post_id ut history_id på den posten.
    * Till skillnad från getHistoryId() så hämtas history id in från en specifik post
    * istället för det högsta history_id + 1 som hämtas i getHistoryId()
    */
    public function getHistoryPost(int $post_id)
    {
        $stmt = self::prepare("SELECT history_id FROM post WHERE id=?");
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $retval = $result->fetch_object()->history_id;
        return $retval;
    }
    /*skapar en ny post med samma history_id som den posten man uppdaterar
    * Tar in, alla kolumner som tillhör post utom changed at
    * Retunerar id på det nya inlägget
    */
    public function editPost(
        int $blog_id,
        int $history_id,
        string $title,
        string $url_title,
        string $content,
        int $anon,
        int $visibility,
        string $publishing_date,
        string $created_at,
        int $user_id
    ) {

        $stmt = self::prepare("INSERT INTO post(blog_id, history_id, title, url_title, content, anonymous_allowance, visibility, publishing_date, created_at, writer) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssiissi', $blog_id, $history_id, $title, $url_title, $content, $anon, $visibility, $publishing_date, $created_at, $user_id);
        $stmt->execute();
        $retval = $stmt->insert_id;
        $stmt->close();
        return $retval;
    }

    public static function getPostId($url_title)
    {
        $stmt = self::prepare("SELECT * FROM post WHERE url_title = ?");
        $stmt->bind_param('s', $url_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }
    public function verifyPostBlogLink(int $blog_id, int $current_post_id, int $history_id, string $blogname)
    {
        $stmt = self::prepare("SELECT id,history_id,blog_id FROM post WHERE id=? AND history_id=? AND blog_id=?");
        $stmt->bind_param('iii', $current_post_id, $history_id, $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $retval = 0;
        if ($result->num_rows > 0) {
            $retval = 1;
        }
        return $retval;
    }
    public function verifyPost($current_post_id, $history_id, $url_title, $publishing_date, $created_at)
    {
        $retval = 1;
        $stmt = self::prepare("SELECT id,history_id,url_title,publishing_date,created_at FROM post WHERE id=?");
        $stmt->bind_param('i', $current_post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        if ($current_post_id != $row->id || $history_id != $row->history_id || $url_title != $row->url_title || $publishing_date != $row->publishing_date || $created_at != $row->created_at) {
            $retval = 0;
        }
      // $dump = array($current_post_id, $row->id, $history_id, $row->history_id, $url_title, $row->url_title,$publishing_date,$row->publishing_date,$created_at,$row->created_at);
      // echo "<pre>";
      // var_dump($dump);
      // echo "</pre>";
        return $retval;
    }
}
