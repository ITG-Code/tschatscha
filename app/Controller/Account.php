<?php
class Account extends Controller
{
    public function send($args = []) {
        $alias = $_POST['alias'];
        $email = $_POST['email'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $oldPassword = $_POST['oldPassword'];
        $id = $this->userModel->getLoggedInUserId();
        if ($oldPassword != '') {
            echo "set";
           if ($this->model('User')->checkInput($id, $oldPassword)) {
                echo "false";
                if ($alias!= '') {
                    echo "alias";
                    $this->model('User')->changeAlias($id, $alias);
                }
                if ($email != '') {
                    echo "email";
                    $this->model('User')->changeEmail($id, $email);
                }
                if ($email != '' && $newPassword == $confirmPassword) {
                        echo "password";
                       $this->model('User')->changePassword($id, $newPassword);
                }
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