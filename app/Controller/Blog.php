<?php
class Blog extends Controller
{
  public function create()
  {
    $blogname = $_POST['blogname'];
    $urlname = $_POST['urlname'];
    if(isset($_POST['nsfw'])){
    $nsfw = 1;
    }
    else{
      $nsfw = 0;
    }

    if(strlen($blogname) <= 3){
      echo "domännamnet måste vara minst fyra karaktärer långt";

    }
    else
    {
      if (!preg_match("/^[a-zA-Z0-9].[a-zA-Z0-9-_]+$/",$urlname)&& strlen($urlname <=3)){
        $urlErr = "Minst fyra karaktärer. Tillåtna tecken: A-Z ,0-9,bindestreck och understreck";
        echo $urlErr;
      }
      else{
      $blogModel = $this->model('Blog');
      $blogModel->createBlog($blogname,$urlname,$nsfw);
        Redirect::to('/login');
      }
    }


  }
  public function createForm()
  {
    $this->view('createBlog');
  }
}
