<?php


class Login extends Controller
{
    public function send()
    {
        if (!isset($_POST['login'])) {
            die("Login without clicking the loginbutton");
        }
        $username = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $privatekey = "6Lf6aQgUAAAAAFzRqiqzT9p8wGpX0GHRz4uDhMhc";
        $response = file_get_contents($url."?secret=".$privatekey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $data = json_decode($response);

        if ($this->model('User')->login($username, $password) && $data->success==true) {
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
