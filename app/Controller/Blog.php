<?php
class Blog extends Controller
{
  public function create()
  {
    $blogname = $_POST['blogname'];
    $urlname = $_POST['urlname'];
    if(strlen($urlname) >= 4){
      echo "domännamnet måste vara minst fyra karaktärer långt";
    }
    //fixa retur grejs eller elseifgrejs.
    if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/",$urlname)){
      $urlErr = "Tillåtna tecken: A-Z,0-9,bindestreck och understreck";
      echo $urlErr;
    }
    else{
    $blogModel = $this->model('Blog');
    $blogModel->createBlog($blogname,$urlname);
      Redirect::to('/login');
    }
  }
  public function createForm()
  {
    $this->view('createBlog');
  }
}
