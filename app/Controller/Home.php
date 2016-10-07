<?php


class Home extends Controller
{
  /**
   * @param array $args
   */
  public function index(array $args = []){
    echo "<a href='/login'>Logga in här</a><br><a href='/register'>Registrera här</a>";
  }
}