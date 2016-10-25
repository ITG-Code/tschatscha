<?php


class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->userModel->isLoggedIn()) {
            Redirect::to('/login');
        }
    }

    public function index()
    {
        $currentUser = $this->userModel->getLoggedInUserId();
        // $getAuth = $this->model('Post')->checkAuth($user_id,$blog_id);
        $this->view(
            'dashboard/index', [
            'user' => $this->userModel->get(Session::get('session_user')),
            'bloglist' => $this->userModel->getYourBlogs($currentUser),
            'followlist' => $this->model('blog')->getFollows($currentUser),
            'acceptFollowList' => $this->model('blog')->getAcceptFollowers($currentUser),
            'allbloglist' => $this->model('blog')->list(),
            // 'authority' => $getAuth,
        ]);
    }

    public function settings($args = [])
    {
        $this->view('dashboard/settings', [

        ]);
    }
}
