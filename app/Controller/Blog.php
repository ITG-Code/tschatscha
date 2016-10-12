<?php

class Blog extends Controller
{
    private $blogName;

    public function __construct(string $blogName = null)
    {
        parent::__construct();
        $this->blogName =  (isset($blogName)) ? $blogName :  null;
    }

    public function index($args = [])
    {
        $this->view('blog/index',[
        
        ]);
    }
     public function settings($args = [])
    {     

     if(!$this->userModel ->isLoggedIn())
       {
          Redirect::to('/login');
        }  

       $search = "";
       $myBlogs = "";

       if(isset($_POST['chooseBlog']) ? true : false){
        $chooseblog = $_POST['chooseBlog'];
        $myBlogs = $this->model('Blog')->chooseBlog($blogName);

       }

        if (isset($_POST['userQuery']) ? true : false) {
            $userquery = $_POST['userQuery'];
            $search = $this->userModel->searchForUser($userquery);
        }
      
        $this->view('blog/settings',[
            //'searchresult' => $this->model('Blog')->chooseBlog($user_id,$blogid,$name)
            'usersearch' => $search,
            'blogpicker' => $myBlogs
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
        $currentUser_id = $this->userModel->getLoggedInUserId();

        if (!strlen($blogname) >= 4) {
            UserError::add(Lang::FORM_BLOGNAME_NEEED_4_CHAR);
        }
        if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/", $urlname) && strlen($urlname <= 3)) {
            UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        if (UserError::exists()) {
            Redirect::to('/blog/createform');
        }
        $blogModel = $this->model('Blog');
        $blogModel->create($blogname, $urlname, $nsfw,$currentUser_id);
        Redirect::to('/dashboard');
    }

    public function setAuthority(int $blog_id)
    {
         if(!$this->userModel ->isLoggedIn())
        {
          Redirect::to('/login');
        }
        /*
        $authority = (isset($_POST['authority'])) ? true : false;
        'user' -> $this->userModel->get(Session::get('session_user'));
        $blog_id = "SELECT id FROM blog WHERE user = ?";
        echo $blog_id;
        */

    }



    public function compose(/*$args = []*/)
    { 
      // if(!$this->userModel->isLoggedIn())
      // {
      //   Redirect::to('/login');
      // }        

//        $args[0] == 'send';
    // $blogname  = $this->blogName;
      $this->view('blog/post/index', [
          'blogname' => $this->blogName
      ]);
    }
    public function sendPost()
    {

        $blogname  = $this->blogName;
        $user_id = $this->userModel->getLoggedInUserId();
        $blog_id = $this->model('blog')->getBlogId($blogname);

        $title = $_POST['Title'];
        $url = $_POST['Url'];
        $content = $_POST['Content'];

        $date = $_POST['Date'];
        $date = $this->fixDate($date);

        if (isset($_POST['Anon'])) {
            $anon = 1; //allow anon
        } else {
            $anon = 0; //dont allow anon
        }
        $auth = $_POST['auth'];
        $time = date('Y-m-d H:i');

        $this->model('post')->createPost($title, $url, $user_id, $blog_id, $content, $date, $anon, $auth, $time);
        echo "title: ".$title."<br>";
        echo "url: ".$url."<br>";
        echo "User_id: ".$user_id."<br>";
        echo "blog id: ".$blog_id."<br>";
        echo "content: ".$content."<br>";
        echo "date: ".$date."<br>";
        echo "anon: ".$anon."<br>";
        echo "auth: ".$auth."<br>";
        echo "time: ".$time."<br>";
    }

    public function fixDate($date)
    {
        if ($date == '') {
            $date = date('Y-m-d H:i');
            return $date;
        }
        $date = str_replace('T', ' ', $date);
        if (DateTime::createFromFormat('Y-m-d H:i', $date) !== FALSE) {
            //rätt format
            //echo "hej";
            return $date;
        } else {
            //fel medelande här inte någon return
             UserError::add('Insert real date');
             return date('Y-m-d H:i');
        }

    }
}
