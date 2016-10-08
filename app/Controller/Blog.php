<?php

class Blog extends Controller
{
  public function create()
  {
    $blogname = $_POST['blogname'];
    $urlname = $_POST['urlname'];
    $nsfw = (isset($_POST['nsfw'])) ? true : false;

    if(!strlen($blogname) >= 4) {
      Flasher::addError("Domännamnet måste vara minst fyra karaktärer långt");
    }
    if(!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/", $urlname) && strlen($urlname <= 3)) {
      Flasher::addError("Minst fyra karaktärer. Tillåtna tecken: A-Z ,0-9,bindestreck och understreck");
    }
    if(Flasher::errorsExist()) {
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
