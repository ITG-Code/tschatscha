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
            UserError::add("Domännamnet måste vara minst fyra karaktärer långt");
        }
        if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/", $urlname) && strlen($urlname <= 3)) {
            UserError::add("Minst fyra karaktärer. Tillåtna tecken: A-Z ,0-9,bindestreck och understreck");
        }
        if (UserError::exists()) {
            Redirect::to('/blog/createform');
        }
        $blogModel = $this->model('Blog');
        $blogModel->create($blogname, $urlname, $nsfw,$currentUser_id);
        Redirect::to('/dashboard');
    }

    public function setAuthority()
    {
         if(!$this->userModel ->isLoggedIn())
        {
          Redirect::to('/login');
        }
        $authority = (isset($_POST['authority'])) ? true : false;

         $stmt = self::prepare('SELECT * FROM blog WHERE url_name = ?');
        $stmt->bind_param('s', $blogName);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return ($result->num_rows >= 1) ? true : false;
    }

    //grejer till posts/inlägg.
}
