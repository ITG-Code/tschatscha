<?php
class Blog extends Controller
{
  public function create()
  {
    $blogname = strip_tags($_POST['blogname']);
    $urlname = strip_tags($_POST['urlname']);

    $sql = "INSERT INTO blog(name, url_name) values(?,?)";
    $blogModel = $this->model('BlogModel');
    $blogModel->createBlog($blogname,$urlname,$sql);
  }
  public function createForm()
  {
    $this->view('createBlog');
  }
}
