<?php

class Register extends Controller
{
  public function send($args = []){
      // Where you send register form to process registration
  }
  public function index(){
    $this->view('view/register');
  }
  public function activateAccount($args = []){
    if(!isset($args[0])){
      $this->view('errormessage/activate_account_notoken.php');
      exit();
    }
    $token = $args[0];

  }

}