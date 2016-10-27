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
        $getBlogs = $this->userModel->getYourBlogs($currentUser);
        $auth = 0;
        

        // if(!isset($blog_id)){
            
        //     $auth = 0;
        // }


        $this->view(
            'dashboard/index',
            [
            'user' => $this->userModel->get(Session::get('session_user')),
            'bloglist' => $this->userModel->getYourBlogs($currentUser),
            'followlist' => $this->model('blog')->getFollows($currentUser),
            'acceptFollowList' => $this->model('blog')->getAcceptFollowers($currentUser),
            'allbloglist' => $this->model('blog')->list(),
            'loggedin' => $currentUser,
            'bloglist' => $getBlogs,
            'auth' => $auth,
            // 'authority' => $getAuth,
            ]
        );
    }

    public function settings($args = [])
    {
        $this->view('dashboard/settings', [

        ]);
    }
}
