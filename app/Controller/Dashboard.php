<?php


class Dashboard extends Controller
{
  public function index(){
    if(!$this->model('User')->isLoggedIn()){
      Redirect::to('/login');
    }
    echo "Your are logged in!";
  }
}