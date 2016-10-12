<?php


class Home extends Controller
{
    /**
     * @param array $args
     */
    public function index(array $args = [])
    {

        $userModel = $this->model("User");
        if ($this->userModel->isLoggedIn()) {
            Redirect::to('/dashboard');
        }
        $this->view(
            'home/index', [
            //'bloglist' => $this->model("Blog")->list(),
            ]
        );
    }
}
