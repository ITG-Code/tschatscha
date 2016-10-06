<?php
class Blog extends Controller
{
  public function create()
  {
    $blogname = strip_tags($_POST['blogname']);
    $urlname = strip_tags($_POST['urlname']);

    
    $blogModel = $this->model('BlogModel');
    $blogModel->createBlog($blogname,$urlname);
  }
  public function createForm()
  {
    $this->view('createBlog');
  }
}
