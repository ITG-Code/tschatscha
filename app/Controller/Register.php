<?php

class Register extends Controller
{
  public function send($args = []){
      // Where you send register form to process registration
  	$username = $_POST['username'];
  	$password = $_POST['password'];
  	$email = $_POST['email'];
  	$alias = $_POST['alias'];
  	$firstname = $_POST['firstname'];
  	$surname = $_POST['surname'];
  	$birthday = $_POST['birthday'];

  	
  }
  public function index(){
    $this->view('register');
  }
}