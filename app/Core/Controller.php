<?php

class Controller
{
  protected function model(string $modelName, array $args = [])
  {
    require_once '../app/Model/' . ucfirst($modelName) . '.php';
    $model = ucfirst($modelName);
    return new $model($args);
  }

  protected function view(string $view, array $data = [])
  {
    $data = (object)$data;
    require_once '../app/view/' . $view . '.php';
  }
}