<?php

class Blog extends Controller
{
    private $blogName;

    public function __construct(string $blogName = null)
    {
        parent::__construct();
        $this->blogName = (isset($blogName)) ? $blogName : null;
    }

    public function index($args = [])
    {
        // TODO: Add thing that tells if a post exists or not

        $this->view('blog/index', [
            'postlist' => $this->model('Post')->get($this->blogName),
        ]);


    }

    public function post($args = [])
    {
        if ($args[0] == "compose") {
            unset($args[0]);
            $args = $args ? array_values($args) : [];
            $this->compose($args);
        } else {
            $this->view('blog/post/index', [
                'post' => $this->model('Post')->get($this->blogName, $args[0], 0, 0, false),
            ]);
        }
    }

    public function settings($args = [])
    {
        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }

        $search = [];

        if (isset($_POST['userQuery'])) {
            $userquery = $_POST['userQuery'];
            $search = $this->userModel->searchForUser($userquery);
        }

        $authorityLevel = [];

        if(isset($_POST['authority']))
        {
            $setAuthority = $_POST['authority'];
            $userId = $_POST['user_id'];
            $authority = $this->model('Blog')->setAuthority($setAuthority, $this->blogName, $userId);

            // $blogname = $this->blogName;
            // $blog_id = $this->model('blog')->getBlogId($blogname);
            if (isset($_POST['authority'])) {
              $setAuthority = $_POST['authority'];
              $userId = $_POST['user_id'];
              $authority = $this->model('Blog')->setAuthority($setAuthority, $this->blogName, $userId);
        }

        $this->view('blog/settings', [
            'usersearch' => $search,
            //'authorityLvl' => $authority,
        ]);

    }
  }

    public function create()
    {

        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }
        $blogname = (isset($_POST['blogname'])) ? $_POST['blogname'] : '';
        $urlname = (isset($_POST['urlname'])) ? $_POST['urlname'] : '';
        $tags = (isset($_POST['tags'])) ? $_POST['tags'] : '';
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
        $id = $blogModel->create($blogname, $urlname,$tags, $nsfw,$currentUser_id);
        echo $id;
        if(strlen($tags) > 0)
        {
          $this ->model('tag')->checkTag($tags,false,$id,$blogname);

        }
        // Redirect::to('/dashboard');
        $blogModel->create($blogname, $urlname, $nsfw, $currentUser_id);
        Redirect::to('/dashboard');
    }


    public function compose($args = [])
    {
        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }
        $auth = $this->model('post')->checkAuth($this->model('blog')->getBlogId($this->blogName), $this->userModel->getLoggedInUserId());
        if ($auth < 6) {
            Redirect::to('/login');
        }
        $this->view('blog/post/compose', [
        ]);
    }

    public function sendPost()
    {
        $title = $_POST['Title'];
        $url = $_POST['Url'];
        $publishing_date = $_POST['Date'];
        $content = $_POST['Content'];
        $tags = $_POST['Tags'];


        //kollar så att datumet är korrekt angivet.
        $publishing_date = $this->fixDate($publishing_date);
        //kollar bloggens id.
        $blog_id = $this->model('blog')->getBlogId($this->blogName);
        //Tar högsta history_id och höjer det med 1.
        $history_id = $this->model('post')->getHistoryId($url);
        //kollar så att url är korrekt angiven.
        $url = $this->fixURL($url, $this->blogName, $blog_id, $this->blogName);


        if (isset($_POST['Anon'])) {
            $anon = 1; //allow anon
        } else {
            $anon = 0; //dont allow anon
        }
        $auth = $_POST['auth'];
        $time = date('Y-m-d H:i');

        $id = $this->model('post')->createPost($title, $url, $this->userModel->getLoggedInUserId(), $blog_id, $history_id, $content, $publishing_date, $anon, $auth, $time);
        //fixar taggar
        $this->model('tag')->checkTag($tags, true, $id, $this->blogName);

        Redirect::to("/$this->blogName/$url");
    }

    //indata = titel url och blognamn, utdata = titel url/error, byter ut ' ' mot '-' och kolla efter icketillåtna tecken.
    public function fixURL(string $url, string $blogname, int $blog_id)
    {
        $url = str_replace(' ', '-', $url);
        $unique = $this->model('post')->checkURL($url, $blog_id);
        if ($unique == false) {
            UserError::add(Lang::FORM_POST_URL_NOT_UNIQUE);
            Redirect::to('/' . $blogname . '/compose');
        }
        if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-]+$/", $url)) {
            UserError::add(Lang::FORM_POST_URL_INVALID_CHARS);
            Redirect::to('/' . $blogname . '/compose');
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

    protected function view(string $view, array $data = [])
    {
        $data['blogname'] = $this->blogName;
        parent::view($view, $data);
    }
}
