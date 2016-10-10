<?php

class Blog extends Controller
{
    public function __construct()
    {

    }

    public function index($args = [])
    {
        echo "In the future this method will show the face of a blog";
        //$this->view('blog/index',[
        //
        //]);
    }

    public function create()
    {
        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }
        $blogname = $_POST['blogname'];
        $urlname = $_POST['urlname'];
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

    public function createForm()
    {
        $this->view('createBlog');
    }
}
