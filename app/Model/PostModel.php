<?php
class PostModel extends Model
{
  public function __construct()
  {
      parent::__construct();
  }
  public function createPost()
  {
    // if(!$this->userModel->isLoggedIn())
    // {
    //   Redirect::to('/login');
    // }
    $this->view('post/index');
  }
}
