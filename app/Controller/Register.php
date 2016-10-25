<?php

class Register extends Controller
{
    public function send($args = [])
    {
        // Where you send register form to process registration
        $username = $_POST['username'];
        if (!preg_match("/^[a-öA-Ö0-9].[a-zA-Z0-9-_]+$/", $username)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $password = $_POST['password'];
        $email = $_POST['email'];
        if (!preg_match("/^[a-öA-Ö0-9.@]+$/", $email)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $alias = $_POST['alias'];
        if (!preg_match("/^[a-öA-Ö0-9].[a-öA-Ö0-9-_]+$/", $alias)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $firstname = $_POST['firstname'];
        if (!preg_match("/^[a-öA-Ö]+$/", $firstname)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $surname = $_POST['surname'];
        if (!preg_match("/^[a-öA-Ö]+$/", $surname)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $birthday = $_POST['birthday'];
        if (!preg_match("/^[0-9-_]+$/", $birthday)) {
          UserError::add(Lang::FORM_BLOGNAME_INVALID_CHARS);
        }
        $captcha = (isset($_POST['g-recaptcha-response'])) ? $_POST['g-recaptcha-response'] : '';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $privatekey = "6Lf6aQgUAAAAAFzRqiqzT9p8wGpX0GHRz4uDhMhc";
        $response = file_get_contents($url."?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $data = json_decode($response);
        if (UserError::exists()) {
           Redirect::to('/register');
        } else if ((!$this->model('User')->create($username, $password, $email, $alias, $firstname, $surname, $birthday) || $data->success==false || (!isset($_POST['terms'])))) {
            Redirect::to('/register');
        } else {
            Redirect::to('/login');
        }
    }

    public function index()
    {
        $currentUser = 0;
        $getBlogs = 0;
        $auth = 0;
        $this->view('register/index', [
            'loggedin' => $currentUser,
            'auth' => $auth,
            'bloglist' => $getBlogs,

            ]);
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

    public function terms()
    {
        $this->view('register/terms');
    }
}

