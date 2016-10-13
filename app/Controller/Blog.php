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

       $search = [];

        if (isset($_POST['userQuery'])) {
            $userquery = $_POST['userQuery'];
            $search = $this->userModel->searchForUser($userquery);
        }
        if(isset($_POST['authority'])){
            $setAuthority = $_POST['authority'];
            $authority = $this->model('Blog')->setAuthority($setAuthority);
        }

        $this->view('blog/settings',[
            'usersearch' => $search,
           // 'authorityLvl' => $authority
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


    public function compose(/*$args = []*/)
    {
      if(!$this->userModel->isLoggedIn())
      {
        Redirect::to('/login');
      }
      $user_id = $this->userModel->getLoggedInUserId();
      $blogname = $this->blogName;
      $blog_id = $this->model('blog')->getBlogId($blogname);

      $auth = $this->model('post')->checkAuth($blog_id, $user_id);
      if ($auth < 6) {
          Redirect::to('/'.$blogname);
      }
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
        $history_id = $this->model('post')->getHistoryId($url);
        //kollar så att url är korrekt angiven.
        $url =$this->fixURL($url,$blogname,$blog_id);

        if (isset($_POST['Anon'])) {
            $anon = 1; //allow anon
        } else {
            $anon = 0; //dont allow anon
        }
        $auth = $_POST['auth'];
        $time = date('Y-m-d H:i');

        $this->model('post')->createPost($title, $url, $user_id, $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time);
        Redirect::to('/'.$blogname.'/') ;
    }

    //indata = titel url och blognamn, utdata = titel url/error, byter ut ' ' mot '-' och kolla efter icketillåtna tecken.
    public function fixURL(string $url, string $blogname, int $blog_id)
    {
      $url = str_replace(' ', '-', $url);
      $unique = $this->model('post')->checkURL($url);
      if(!$unique){
        UserError::add(Lang::FORM_POST_URL_NOT_UNIQUE);
        Redirect::to('/'.$blogname.'/compose');
      }
      if(!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-]+$/", $url)){
        UserError::add(Lang::FORM_POST_URL_INVALID_CHARS);
        Redirect::to('/'.$blogname.'/compose');
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
