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
        require_once 'app/Model/' . ucfirst($modelName) . 'Model.php';
        $model = ucfirst($modelName . "Model");
        return new $model($args);
    }

    protected function view(string $view, array $data = [])
    {
        $data['errors'] = UserError::getArray();
        $data = (object)$data;
        require_once 'app/View/' . $view . '.php';
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}
