<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/Core/App.php';
require_once '../app/Core/Controller.php';
require_once '../app/Core/DatabaseConfig.php';
require_once '../app/Core/Model.php';


$app = new App;