<?php


class Login extends Controller
{
    public function send()
    {
        if (!isset($_POST['login'])) {
            die("Login without clicking the loginbutton");
        }
        $username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
        $password = (isset($_POST['password'])) ? trim($_POST['password']) : '';
        $captcha = (isset($_POST['g-recaptcha-response'])) ? $_POST['g-recaptcha-response'] : '';

        if(empty($username)){
            //UserError::add(Lang::)
        }
        if(empty($password)){
            UserError::add(Lang::FORM_PASSWORD_SENT_NO);
        }
        if(empty($captcha)){
            UserError::add('Captcha token'/* Add error for invalid capcha */);
        }
        if(UserError::exists()){
            Redirect::to('/login');
        }


        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $privatekey = "6Lf6aQgUAAAAAFzRqiqzT9p8wGpX0GHRz4uDhMhc";
        $response = file_get_contents($url."?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $data = json_decode($response);

        if ($this->model('User')->login($username, $password) && $data->success) {
            //Redirect to logged in page
            Redirect::to('/dashboard');
        } else {
            //TODO: Redirect back to login page with errors
            Redirect::to('/login');
        }
    }

    public function index()
    {
        $this->view('login/index');
    }
}
