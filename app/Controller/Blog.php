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

            'postlist' => $this->model('Post')->getByName(),



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

        $title = $_POST['Title'];
        $url = $_POST['Url'];
        $publishing_date = $_POST['Date'];
        $content = $_POST['Content'];

        //kollar så att datumet är korrekt angivet.
        $publishing_date = $this->fixDate($publishing_date);
        //kollar inloggade användarens id.
        $user_id = $this->userModel->getLoggedInUserId();
        //kollar bloggens namn.
        $blogname = $this->blogName;
        //kollar bloggens id.
        $blog_id = $this->model('blog')->getBlogId($blogname);
        //Tar högsta history_id och höjer det med 1.
        $history_id = $this->model('post')->getHistoryId();
        //kollar så att url är korrekt angiven.
        $url =$this->fixURL($url,$blogname);

        if (isset($_POST['Anon'])) {
            $anon = 1; //allow anon
        } else {
            $anon = 0; //dont allow anon
        }
        $auth = $_POST['auth'];
        $time = date('Y-m-d H:i');

        $this->model('post')->createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time);
        echo "title: ".$title."<br>";
        echo "url: ".$url."<br>";
        echo "User_id: ".$user_id."<br>";
        echo "blog id: ".$blog_id."<br>";
        echo "content: ".$content."<br>";
        echo "date: ".$publishing_date."<br>";
        echo "anon: ".$anon."<br>";
        echo "auth: ".$auth."<br>";
        echo "time: ".$time."<br>";
    }


    public function fixDate($date)

    //indata = titel url och blognamn, utdata = titel url/error, byter ut ' ' mot '-' och kolla efter icketillåtna tecken.
    public function fixURL(string $url, string $blogname)

    {
      $url = str_replace(' ', '-', $url);
      if(!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-]+$/", $url)){
        UserError::add(Lang::FORM_POST_URL_INVALID_CHARS);
        Redirect::to('/'.$blogname.'/compose') ;
      }
      return $url;
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
}
