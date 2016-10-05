<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/Core/App.php';
require_once '../app/Core/Controller.php';
if(!file_exists('../app/Core/DatabaseConfig.php')){
  echo "<pre>/**
 * Class DatabaseConfig not found
 * Copy app/Core/DatabaseConfig.template.php to app/Core/DatabaseConfig.php in order for the Database class to work
 */</pre>";
  exit();
}else
  require_once '../app/Core/DatabaseConfig.php';

require_once '../app/Core/Model.php';


$app = new App;