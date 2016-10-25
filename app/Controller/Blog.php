<?php

class Blog extends Controller
{
    private $blogName;

    public function __construct(string $blogName = null)
    {
        parent::__construct();
        //TODO: URL parsing for /blog/blogname
        $this->blogName =  (isset($blogName)) ? $blogName :  null;
    }

    public function index($args = [])
    {
      $blogname = $this->blogName;
      $currentUser = $this->userModel->getLoggedInUserId();
      $blog_id = $this->model('blog')->getBlogId($blogname);
      $user_id = $this->userModel->getLoggedInUserId();
      $postlist = $this->model('Post')->get($this->blogName);


        if(isset($args[0]) && $args[0] ==  'post'){
            unset($args[0]);
            $args = array_values($args);
            $this->post($args);
        }else{
            $auth = 0;
            $anon = 0;
            $followstatus = array();
            $getBlogs = array();
            if ($this->userModel ->isLoggedIn()) {
              $auth = $this->model('Post')->checkAuth($blog_id, $user_id);
              $anon = 1;
              $followstatus = $this->model('blog')->getFollowStatus($user_id,$blog_id);
              $getBlogs = $this->userModel->getYourBlogs($currentUser);
            }

            $this->view('blog/index',[
                'postlist' => $postlist,
                'linked_title' => true,
                'auth' => $auth,
                'anon' => $anon,
                'loggedin' => $currentUser,
                'followstatus' => $followstatus,
                'bloglist' => $getBlogs,
            ]);
        }

    }



    public function post($args = []){
      // $post_id = $this->model('post')->getPostId($id);
      // $post_tag = $this->model('tag')->getTags($post_id);
      $blogname = $this->blogName;
      $blog_id = $this->model('blog')->getBlogId($blogname);
      $user_id = $this->userModel->getLoggedInUserId();
      if ($this->userModel ->isLoggedIn()) {
              $auth = $this->model('Post')->checkAuth($blog_id, $user_id);
            }
        if (isset($args[0]) && $args[0] == "compose") {
            unset($args[0]);
            $args = $args ? array_values($args) : [];
            $this->compose($args);

        } elseif(isset($args[1]) && $args[1] == "delete" && !empty($_POST['delete']) && $auth>=6){
            $post_id = $_POST['delete'];
            $this->model('Post')->deletePost($post_id, $user_id);
           Redirect::to('/'.$blogname);
           if($auth<6){
            Redirect::to('/'.$blogname);
           }
         } elseif(isset($args[1]) && $args[1] == "edit" && $auth >=6){
           $posturl = $args[0];
           $post_id = $this->model('Post')->get($blogname,$posturl);
          //  echo "<pre>";
          //  var_dump($postContent);
          //skickas till post/edit.php och sen därifrån till blog kontroller->editPost
           $this->view('/blog/post/edit', [
             'autoFillPost' => $post_id[0],
           ]);
           if($auth<6){
             Redirect::to('/'.$blogname.'/post/'.$post_url);
           }

         }

        elseif(isset($args[0])) {

            $auth = 0;
            $anon = 0;
            if ($this->userModel ->isLoggedIn()) {
              $user_id = $this->userModel->getLoggedInUserId();
              $auth = $this->model('Post')->checkAuth($blog_id, $user_id);
              $anon = 1;
            }
            $post = $this->model('Post')->get($this->blogName, $args[0]);
            $postid = $post[0]->id;
            $history_id = $this->model('post')->getHistoryPost($postid);
            $comments = $this->model('Post')->getComments($history_id);
            $this->view('blog/post/index', [

                'post' => $post,
                'linked_title' => false,
                'auth' => $auth,
                'anon' => $anon,
                'comments' => $comments,
                // 'postTag' => $post_tag,
            ]);
        }
        else{
            $this->index();
        }


    }
     public function settings($args = [])
    {
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        $blogname = $this->blogName;
        $currentUser = $this->userModel->getLoggedInUserId();
        $blog_id = $this->model('blog')->getBlogId($blogname);
        $getBlogs = $this->userModel->getYourBlogs($currentUser);
        $user_id = $this->userModel->getUserId($blog_id);


        if(!$this->userModel ->isLoggedIn())
       {
          Redirect::to('/login');
        }

        $auth = $this->model('post')->checkAuth($blog_id, $currentUser);
        if ($auth != 7) {
          Redirect::to('/'.$blogname);
        }
        if (empty($confirmPassword)) {
            UserError::add(Lang::FORM_CONFIRMATION_PASSWORD_SENT_NO);
        }
        if (!password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId())->password)) {
            UserError::add(Lang::FORM_PASSWORD_ORIGINAL_INVALID);
        }
        if(isset($_POST['delete']) && !empty($confirmPassword) && password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId())->password) == true){
          $blog_id = $_POST['delete'];
          $bloggen = $this->model('Blog')->deleteBlog($blog_id);
          Redirect::to('/dashboard');
        }

        $search = [];


        if (isset($_POST['userQuery']) && !empty($_POST['userQuery'])) {
            $userquery = $_POST['userQuery'];
            $search = $this->userModel->searchForUser($userquery, $currentUser);
        }

        if(isset($_POST['authority']))
        {
            (int) $setAuthority = $_POST['authority'];
            $userId = $_POST['user_id'];
            $authority = $this->model('Blog')->setAuthority($userId, $this->blogName,(int) $setAuthority);
            Redirect::to('/'.$blogname.'/settings');
        }
        if(isset($_POST['removerights'])){
          $user_id = $_POST['removerights'];
          $userAuth = $this->model('blog')->removeUserRight($user_id,$blog_id);
          Redirect::to('/'.$blogname.'/settings');
        }





        $this->view('blog/settings',[
            'usersearch' => $search,
            'blogname' => $this->blogName,
            'blogid' => $blog_id,
            'user' => $this->userModel->get(Session::get('session_user')),
            'tags' => $this->model("Tag")->changeTags($blog_id),
            'bloglist' => $getBlogs,
            'userID' => $user_id,

        ]);

    }

    public function create()
    {

       if(!$this->userModel ->isLoggedIn())
       {
          Redirect::to('/login');
        }
        $blogname = (isset($_POST['blogname'])) ? $_POST['blogname'] : '';
        $urlname = (isset($_POST['urlname'])) ? $_POST['urlname'] : '';
        $nsfw = (isset($_POST['nsfw'])) ? true : false;
        $tags = (isset($_POST['tags'])) ? $_POST['tags'] : '';
        $currentUser_id = $this->userModel->getLoggedInUserId();

        if (!strlen($blogname) >= 4) {
          UserError::add(Lang::FORM_BLOGNAME_NEEED_4_CHAR);
        }
        if(!preg_match("/^[a-öA-Ö0-9].[a-öA-Ö0-9-_s]+$/",$blogname)){
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $urlname = strtolower($urlname);
        //blacklist array, enter in lowercase. Prevents user from having their blog url be something important.
        $blacklist = array('create','dashboard','sendpost','compose','home','fixdate','fixurl','blog','account','login','logout','register','change_alias','change_email','change_password','index'
        ,'create','settings','post','updatetags','view','model', 'search','send','activateaccount','follow');
        if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/", $urlname) && strlen($urlname <= 3)) {
          UserError::add(Lang::FORM_BLOGURL_INVALID_CHARS);
          UserError::add(Lang::FORM_BLOGNAME_NEEED_4_CHAR);
        }
        if (in_array($urlname, $blacklist)){
          UserError::add(Lang::FORM_BLOGNAME_RESERVED_NAME);
        }
        $unique = $this->model('Blog')->uniqueURLBlog($urlname);
        if(!$unique){
          UserError::add(LANG::FORM_URLNAME_NOT_UNIQUE);
        }
        if (UserError::exists()) {
          Redirect::to('/dashboard');
        }
        $blogModel = $this->model('Blog');
        $id = $blogModel->create($blogname, $urlname, $nsfw,$currentUser_id);
        if(strlen('tags') != 0){
          $this->model('tag')->checkTag($tags,false,$id,$blogname);
        }
        Redirect::to('/'.$blogname);
      }

    public function createComment()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $created_at = date('Y-m-d h:m:s');
        $session_value = session_id();
        $blogname = $this->blogName;
        $user_id = $this->userModel->getLoggedInUserId();
        $content = (isset($_POST['content'])) ? $_POST['content'] : '';
        $post_id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $url_title = (isset($_POST['url_title'])) ? $_POST['url_title'] : '';
        $history_id = $this->model('post')->getHistoryPost($post_id);
        $this->model('post')->getSession($session_value, $user_id, $ip, $created_at);
        $this->model('post')->createComment($history_id, $content, $user_id, $created_at);
        //echo $history_id, $content, $user_id, $created_at;
        Redirect::to('/'.$blogname.'/post/'.$url_title);
    }

    public function compose($args = [])
    {
      if(!$this->userModel->isLoggedIn())
      {
        Redirect::to('/login');
      }
      $autofillPost = (isset($args[0])) ? $this->model("Post")->get($this->blogName, $args[0])[0] : new stdClass();
      $user_id = $this->userModel->getLoggedInUserId();
      $blogname = $this->blogName;
      $blog_id = $this->model('blog')->getBlogId($blogname);

      $auth = $this->model('post')->checkAuth($blog_id, $user_id);
      if ($auth < 6) {
          Redirect::to('/'.$blogname);
      }

      $this->view('blog/post/compose', [
          'autoFillPost' => $autofillPost,
          'blogname' => $this->blogName
      ]);
    }
    public function sendPost()
    {
        // Jakob was not here :)

        $title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $url = isset($_POST['Url']) ? $_POST['Url'] : '';
        $publishing_date = isset($_POST['Date']) ? $_POST['Date'] : '';
        $content = isset($_POST['Content']) ? $_POST['Content'] : '';
        $tags = isset($_POST['Tags']) ? $_POST['Tags'] : '';



        //kollar så att datumet är korrekt angivet.
        $publishing_date = $this->fixDate($publishing_date);
        //kollar inloggade användarens id.
        $user_id = $this->userModel->getLoggedInUserId();
        //kollar bloggens namn.
        $blogname = $this->blogName;
        //kollar bloggens id.
        $blog_id = $this->model('blog')->getBlogId($blogname);
        //Tar högsta history_id och höjer det med 1.
        $history_id = $this->model('post')->getHistoryId($url);
        //kollar så att url är korrekt angiven.
        $url =$this->model('post')->checkURL($url,$blogname,$blog_id);

        if (isset($_POST['Anon'])) {
          $anon = 1; //allow anon
        } else {
            $anon = 0; //dont allow anon
        }
        $auth = $_POST['auth'];
        $time = date('Y-m-d H:i');

        $id = $this->model('post')->createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time);
        //fixar taggar
        $this->model('tag')->checkTag($tags, true, $id, $blogname);
        Redirect::to('/'.$blogname.'/') ;
    }
    //redigera inlägg.
    public function editPost()
      {
        $blogname = $this->blogName;
        $current_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $history_id = isset($_POST['history_id']) ? $_POST['history_id'] : '';
        if(!is_int($current_post_id) || !is_int($history_id)){
          UserError::add(Lang::ERROR_OCCURED);
          Redirect::to('/'.$blogname);
        }

        $blog_id = $this->model('blog')->getBlogId($blogname);
        $user_id = $this->model('user')->getLoggedInUserId();
        $auth = $this->model('post')->checkAuth($blog_id, $user_id);
        //returns 1 if blog and post link
        $verified = $this->model('post')->verifyPostBlogLink($blog_id,$current_post_id,$history_id,$blogname);
        if($verified == 0){
          UserError::add(Lang::BLOG_POST_CONNECTION_MISSING);
          Redirect::to('/'.$blogname);
        }

        if(!$this->userModel ->isLoggedIn())
        {
            Redirect::to('/'.$blogname);
        }
        if ($auth < 6) {
            Redirect::to('/'.$blogname);
        }
        //värden som får ändras i redigering.
        $title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $content = isset($_POST['Content']) ? $_POST['Content'] : '';
        $anon = isset($_POST['anon']) ? $_POST['anon'] : '0';
        $visibility = isset($_POST['auth']) ? $_POST['auth'] : '0';

        //värden som tillsammans med history id inte ska ändras i redigering.
        $url_title = isset($_POST['url_title']) ? $_POST['url_title'] : '';
        $publishing_date = isset($_POST['publishing_date']) ? $_POST['publishing_date'] : '';
        $created_at = isset($_POST['created_at']) ? $_POST['created_at'] : '';
        if(!is_string($url_title) || !is_string($publishing_date) || !is_string($created_at)){
          UserError::add(Lang::ERROR_OCCURED);
          Redirect::to('/'.$blogname);
        }

        //returns 1 if attributes match with current post.
        $postVerify = $this->model('post')->verifyPost($current_post_id,$history_id,$url_title,$publishing_date,$created_at);
        // echo $postVerify;
        if($postVerify == 0 ){
          UserError::add(Lang::ERROR_OCCURED);
          Redirect::to('/'.$blogname);
        }

        $new_post_id = $this->model('post')->editPost($blog_id,$history_id,$title,$url_title,$content,$anon,$visibility,$publishing_date,$created_at,$user_id);
        $this->model('tag')->relocateTags($current_post_id,$new_post_id);
        Redirect::to('/'.$blogname.'/post/'.$url_title);
      }


    //indata=datum, utdata=datum -T om det finns, kollar så att datum är korrekt angivet.
    public function fixDate($publishing_date)
    {
        if ($publishing_date == '') {
            $publishing_date = date('Y-m-d H:i');
            return $publishing_date;
        }
        $publishing_date = str_replace('T', ' ', $publishing_date);
        if (DateTime::createFromFormat('Y-m-d H:i', $publishing_date) !== FALSE) {
            //rätt format
            //echo "hej";
            return $publishing_date;
        } else {
            //felmedelande här inte någon return
             UserError::add(Lang::FORM_POST_DATE_INVALID);
             return date('Y-m-d H:i');
        }

    }
     protected function view(string $view, array $data = [])
     {
        $data['blogname'] = $this->blogName;
        parent::view($view, $data);
     }

     public function updateTags($args = [])
     {
        $blogname = $this->blogName;
        $blog_id = $this->model('blog')->getBlogId($blogname);

        if(!empty($_POST['tag'])) {
            foreach($_POST['tag'] as $tag) {
              $this->model('tag')->deleteTagBlog($blog_id,$tag);
            }
        }
        if (isset($_POST['tags'])) {
          $this->model('tag')->checkTag($_POST['tags'], false, $blog_id, $blogname);
        }
        Redirect::to('/'.$blogname.'/settings');
     }
     public function follow()
     {
        if(!$this->userModel->isLoggedIn())
        {
        Redirect::to('/login');
        }
        $user_id = $this->userModel->getLoggedInUserId();
        $blogname = $this->blogName;
        $blog_id = $this->model('blog')->getBlogId($blogname);
        $date = date('Y-m-d H:i:s');
        $this->model('blog')->follow($user_id, $blog_id, $date);

        Redirect::to('/'.$blogname);
     }
     public function acceptFollower()
     {
        $redict = '/blog/allFollowers';
        if ($_POST['redict'] == 1) {
          $redict = '/dashboard';
        }
        if (!isset($_POST['id']) && !isset($_POST['blog_id'])) {
          Redirect::to($redict);
        }
        $follower_id = $_POST['id'];
        $blog_id = $_POST['blog_id'];
        $this->model('blog')->acceptFollower($follower_id, $blog_id);
        Redirect::to($redict);
     }

     public function deleteFollower()
     {

        $redict = '/blog/allFollowers';
        if ($_POST['redict'] == 1) {
          $redict = '/dashboard';
        }
        if (!isset($_POST['id']) && !isset($_POST['blog_id'])) {
          Redirect::to($redict);
        }
        $follower_id = $_POST['id'];
        $blog_id = $_POST['blog_id'];
        $this->model('blog')->deleteFollower($follower_id, $blog_id);
        Redirect::to($redict);
     }

     public function allFollowers()
     {

      if ($this->userModel ->isLoggedIn()) {
              $user_id = $this->userModel->getLoggedInUserId();
              $getBlogs = $this->userModel->getBlogsWithAuth($user_id);
              $list = $this->model('blog')->getFollowers($user_id);
              //$acceptlist = $this->model('blog')->getAcceptFollowers($user_id);
              $this->view('/dashboard/bigList', [
                        'list' => $list,
                        // 'acceptlist' => $acceptlist,
                        //'auth' => $authority,
                        'blogs' => $getBlogs,
                        'bloglist' => $getBlogs,

                    ]);
            }



     }
}
