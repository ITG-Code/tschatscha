<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Adding autoloading for libraries
require_once '../vendor/autoload.php';
// For stylish stack traces
\php_error\reportErrors();

// Loading non autoloaded files
require_once '../app/Core/App.php';
require_once '../app/Helper/Session.php';
require_once '../app/Helper/Redirect.php';
require_once '../app/Helper/Flasher.php';

require_once '../app/Core/Controller.php';
if(!file_exists('../app/Core/DatabaseConfig.php')){
  echo "<pre>/**
 * Class DatabaseConfig not found
 * Copy app/Core/DatabaseConfig.template.php to app/Core/DatabaseConfig.php in order for the Database class to work
 */</pre>";
  exit();
}else
  require_once '../app/Core/DatabaseConfig.php';
if(!file_exists('../app/Config/MailerConfig.php')){
  echo "<pre>/**
 * Class MailerConfig not found
 * Copy app/Config/MailerConfig.template.php to app/Config/MailerConfig.php in order for the Database class to work
 */</pre>";
  exit();
}else
  require_once '../app/Config/MailerConfig.php';
require_once '../app/Helper/Mailer.php';

require_once '../app/Core/Model.php';

Session::start();
$app = new App;