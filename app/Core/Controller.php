<?php

class Controller
{
  protected function model(string $modelName, $args = [])
  {
    require_once '../app/Model/' . ucfirst( $modelName ). '.php';
    $model =  ucfirst($modelName);
    $model = new $model($args);
    var_dump($model);
  }

  protected function view(string $view, array $data = [])
  {
      //global $data = $data;
      require_once '../app/view/' . $view . '.php';
  }
}