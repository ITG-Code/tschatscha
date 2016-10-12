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

    /**
     * @param string $modelName | expects name of a Model class without the 'Model'-part of the name appended
     * @param array $args
     * @return mixed
     */
    protected function model(string $modelName, array $args = [])
    {
        require_once 'app/Model/' . ucfirst($modelName) . 'Model.php';
        $model = ucfirst($modelName . "Model");
        return new $model($args);
    }

    /**
     * The view to be presented to the client.
     * Root folder for views are in /App/View/
     * Doesn't want the file extension
     * @param string $view
     *
     * All the information that the view needs to present what it's supposed to present.
     * Variables are to be sent to $data as an associative array and then gets turned into an stdClass
     * @param array $data
     *
     */
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
