<?php

class Account extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->userModel->isLoggedIn()) {
            UserError::add(Lang::ACCESS_LOGGED_IN_NO);
            Redirect::to('/login');
        }
    }

    public function change_alias()
    {

        $newAlias = (isset($_POST['alias'])) ? trim($_POST['alias']) : '';
        if (empty($newAlias)) {
            UserError::add(Lang::FORM_ALIAS_SENT_NO);
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add(Lang::FORM_CONFIRMATION_PASSWORD_SENT_NO);
        }
        if (!password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId())->password)) {
            UserError::add(Lang::FORM_PASSWORD_ORIGINAL_INVALID);
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
            UserError::add(Lang::FORM_EMAIL_SENT_NO);
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add(Lang::FORM_CONFIRMATION_PASSWORD_SENT_NO);
        }
        if (password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId()))) {
            UserError::add(Lang::FORM_PASSWORD_ORIGINAL_INVALID);
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
            UserError::add(Lang::FORM_PASSWORD_NEW_SENT_NO);
        }
        $confirmNewPassword = (isset($_POST['confirmnewpassword'])) ? trim($_POST['confirmnewpassword']) : '';
        if (empty($confirmNewPassword)) {
            UserError::add(Lang::FORM_CONFIRMATION_PASSWORD_SENT_NO);
        }
        $confirmPassword = (isset($_POST['confirmpassword'])) ? trim($_POST['confirmpassword']) : '';
        if (empty($confirmPassword)) {
            UserError::add(Lang::FORM_CONFIRMATION_PASSWORD_SENT_NO);
        }
        if ($confirmNewPassword !== $newPassword) {
            UserError::add(Lang::FORM_PASSWORD_NEW_NO_MATCH);
        }
        if (!password_verify($confirmPassword, $this->userModel->get($this->userModel->getLoggedInUserId())->password)) {
            UserError::add(Lang::FORM_PASSWORD_ORIGINAL_INVALID);
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