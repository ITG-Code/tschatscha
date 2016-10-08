<?php

class Controller
{
  protected $userModel;

  public function __construct()
  {
    $this->userModel = $this->model('User');
    //if(Session::exists('session_user'))
    //  $this->userModel->get(Session::get('session_user'));
  }

  protected function model(string $modelName, array $args = [])
  {
    require_once '../app/Model/' . ucfirst($modelName) . 'Model.php';
    $model = ucfirst($modelName . "Model");
    return new $model($args);
  }

  protected function view(string $view, array $data = [])
  {
    $data['errors'] = Flasher::getErrorArray();
    $data = (object)$data;
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    require_once '../app/View/' . $view . '.php';
  }
}