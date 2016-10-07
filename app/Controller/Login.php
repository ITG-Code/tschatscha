<?php


class Login extends Controller
{
  public function send(){
    if(!isset($_POST['login'])){
      die("Login without clicking the loginbutton");
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($this->model('User')->login($username, $password)){
      //Redirect to logged in page
      Redirect::to('/home');
    }else{
      //Redirect back to login page with errors
    }
  }
  public function index(){
    $this->view('login/index');
  }
}