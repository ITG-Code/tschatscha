<?php
class Account extends Controller
{
    public function send($args = []) {
        $alias = $_POST['alias'];
        $email = $_POST['email'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $oldPassword = $_POST['oldPassword'];
        // $id = $this->userModel->getLoggedInUserId();
        if ($this->model('User')->checkInput($oldPassword)) {
            if (isset($_POST['alias'])) {
                echo $alias;
                    // $this->model('User')->
            }
            if (isset($_POST['email'])) {
                echo $email;
                    // $this->model('User')->
            }
            if (isset($_POST['newPassword']) && $newPassword == $confirmPassword) {
                    echo $newPassword;
                    // $this->model('User')->
            }
            if (isset($_POST['nsfw'])) {
                echo "nsfw";
                //är nsfw
                    // $this->model('User')->
            } else {
                echo "sfw";
                //not nsfw
            }   
        }
    }
    public function index($args = [])
    {
        if(!$this->userModel ->isLoggedIn())
       {
          Redirect::to('/login');
        }
        $this->view('account/index',[

        ]);
    }
    public function changeSettings(){
    	$alias = (isset($_POST['alias'])) ? $_POST['alias'] : '';
    	$email = (isset($_POST['email'])) ? $_POST['email'] : '';
    	$password = (isset($_POST['password'])) ? $_POST['password'] : '';

    	echo"Det här borde fungera";


    }
}