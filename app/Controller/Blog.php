<?php

class Blog extends Controller
{
    public function index($args = [])
    {
        $this->view('blog/index',[

        ]);
    }

    public function create()
    {
        if(!$this->userModel->isLoggedIn())
        {
          Redirect::to('/login');
        }
        $blogname = (isset($_POST['blogname'])) ? $_POST['blogname'] : '';
        $urlname = (isset($_POST['urlname'])) ? $_POST['urlname'] : '';
        $nsfw = (isset($_POST['nsfw'])) ? true : false;

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
        $blogModel->create($blogname, $urlname, $nsfw);
        Redirect::to('/dashboard');
    }
}
