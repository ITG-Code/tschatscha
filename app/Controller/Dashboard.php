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
        $getFollowers =  $this->model('blog')->getFollowers($currentUser);
        $this->view(
            'dashboard/index', [
            'user' => $this->userModel->get(Session::get('session_user')),
            'bloglist' => $getBlogs,
            'followlist' => $getFollowers,
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
