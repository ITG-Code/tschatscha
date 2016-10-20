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
        // $blogName = "";

        // if(isset($_POST['chooseBlog'])){
        //     $chooseblog = $_POST['chooseBlog'];
        //     $blogName = $this->userModel->chooseBlog($chooseblog);
        // }


        $currentUser = $this->userModel->getLoggedInUserId();
        $getBlogs = $this->userModel->getYourBlogs($currentUser);
        $getFollows =  $this->model('blog')->getFollows($currentUser);
        $getAcceptFollowers = $this->model('blog')->getAcceptFollowers($currentUser);
        $this->view(
            'dashboard/index', [
            'user' => $this->userModel->get(Session::get('session_user')),
            'bloglist' => $getBlogs,
            'followlist' => $getFollows,
            'acceptFollowList' => $getAcceptFollowers,
            ]
        );
        
            // $blogModel = $this->model('Blog');
            // $blogModel->chooseBlog($blogName);
        }
    
    public function settings($args = []){
        $this->view('dashboard/settings',[

        ]);
    }
}
