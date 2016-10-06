<?php
class Blog extends Controller
{
  public function create()
  {
    $blogname = $_POST['blogname'];
    $urlname = $_POST['urlname'];
    if (!preg_match("/^\S[a-öA-Ö\-\_0-9\s]*$/",$blogname)) {
      $nameErr = "Tillåtna tecken: A-Z,0-9,bindestreck, understreck och mellanslag";
      echo $nameErr;
    }
    else if (!preg_match("/^[a-zA-Z\-\_0-9]*$/",$urlname)){
      $urlErr = "Tillåtna tecken: A-Z,0-9,bindestreck och understreck";
      echo $urlErr;
    }
    else{
    $blogModel = $this->model('Blog');
    $blogModel->createBlog($blogname,$urlname);
    }
  }
  public function createForm()
  {
    $this->view('createBlog');
  }
}
