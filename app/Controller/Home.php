<?php


class Home extends Controller
{
  /**
   * @param array $args
   */
  public function index(array $args = []){

  	$userModel  = $this->model("User");
  	if ($userModel->isLoggedIn()) {
  		echo '	<form action="" method="post">
					<input type="submit" name="Loggout" value="logga ut">
				</form>';
  	} else {
  		echo "<a href='/login'>Logga in här</a><br><a href='/register'>Registrera här</a>";
  	}

    
  }
}