<?php


class Logout extends Controller
{
  public function index()
  {
    $this->userModel->logout();
    Redirect::to('/login');
  }
}