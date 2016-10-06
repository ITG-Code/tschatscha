<?php

class Register extends Controller
{
  public function send($args = []){
      // Where you send register form to process registration
  }
  public function index(){
    $this->view('view/register');
  }
}