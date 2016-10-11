<?php

class Account extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->userModel->isLoggedIn()) {
            UserError::add('You need to be logged to access that page');
            Redirect::to('/login');
        }
    }

    public function change_alias()
    {

        $newAlias = (isset($_POST['alias'])) ? trim($_POST['alias']) : '';
        if (empty($newAlias)) {
            UserError::add('No alias sent');
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add('No confirmation password sent');
        }
        if (password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId()))) {
            UserError::add('Original password didn\'t match');
        }
        if (UserError::exists()) {
            Redirect::to('account/index');
        }
        $this->userModel->changePassword($this->userModel->getLoggedInUserId(), $newAlias);

        Redirect::to('/account/index');
    }

    public function change_email()
    {
        $newEmail = (isset($_POST['email'])) ? trim($_POST['email']) : '';
        if (empty($newEmail)) {
            UserError::add('No email sent');
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add('No confirmation password sent');
        }
        if (password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId()))) {
            UserError::add('Original password didn\'t match');
        }
        if (UserError::exists()) {
            Redirect::to('account/index');
        }
        $this->userModel->changeEmail($this->userModel->getLoggedInUserId(), $newEmail);

        Redirect::to('/account/index');
    }

    public function change_password()
    {

        $newPassword = (isset($_POST['newpassword'])) ? trim($_POST['newpassword']) : '';
        if (empty($newPassword)) {
            UserError::add('No password sent');
        }
        $confirmNewPassword = (isset($_POST['confirmnewpassword'])) ? trim($_POST['confirmnewpassword']) : '';
        if (empty($confirmNewPassword)) {
            UserError::add('No confirmation password sent');
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add('No confirmation password sent');
        }
        if ($confirmNewPassword !== $newPassword) {
            UserError::add('New Password and Password confirmation didn\'t match');
        }
        if (password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId()))) {
            UserError::add('Original password didn\'t match');
        }
        if (UserError::exists()) {
            Redirect::to('account/index');
        }
        $this->userModel->changePassword($this->userModel->getLoggedInUserId(), $newPassword);

        Redirect::to('/account/index');

    }

    public function index($args = [])
    {
        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }
        $this->view('account/index', [

        ]);
    }
}