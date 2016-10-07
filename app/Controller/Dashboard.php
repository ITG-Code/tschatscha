<?php


class Dashboard extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!$this->userModel->isLoggedIn()) {
      Redirect::to('/login');
    }
  }

  public function index()
  {
    $this->view('dashboard/index');
  }
}