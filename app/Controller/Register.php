<?php

class Register extends Controller
{
    public function send($args = [])
    {
        // Where you send register form to process registration
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $alias = $_POST['alias'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $birthday = $_POST['birthday'];

        if (!$this->model('User')->create($username, $password, $email, $alias, $firstname, $surname, $birthday)) {
            Redirect::to('/register');
        } else {
            Redirect::to('/login');
        }
    }

    public function index()
    {
        $this->view('register/index');
    }

    public function activateAccount($args = [])
    {
        if (!isset($args[0])) {
            $this->view('errormessage/activate_account_notoken.php');
            exit();
        }
        $token = $args[0];
        if ($this->model('User')->activate($token)) {
            echo "Your account has been activated";
        } else {
            echo "Activation failed";
        }
    }
}
