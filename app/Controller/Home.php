<?php


class Home extends Controller
{
    /**
     * @param array $args
     */
    public function index(array $args = [])
    {
        $user_id = $this->userModel->getLoggedInUserId();

        $userModel = $this->model("User");
        if ($this->userModel->isLoggedIn()) {
            Redirect::to('/dashboard');
        }
        $this->view(
            'home/index', [
            'bloglist' => $this->model("Blog")->list(),
            'loggedin' => $user_id,
            ]
        );
    }
    public function search(array $args = []){
        $searchResult = (isset($args[0])) ? $this->model('Blog')->find(trim($args[0])) : [];
        $this->view('home/search',[
            'result' => $searchResult,
        ]);
    }
}
