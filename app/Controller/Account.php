<?php
class Account extends Controller
{
    public function index($args = [])
    {
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