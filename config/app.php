<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
use \Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');

$dotenv->load();



define('DB_HOST', $_ENV['RAILWAY_DATABASE_HOST']);
define('DB_USER', $_ENV['RAILWAY_DATABASE_USERNAME']);
define('DB_PASSWORD', $_ENV['RAILWAY_DATABASE_PASSWORD']);
define('DB_DATABASE', $_ENV['RAILWAY_DATABASE_NAME']);
define('DB_PORT', $_ENV['RAILWAY_DATABASE_PORT']);

if ($_SERVER['HTTP_HOST'] === 'localhost') {
  define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/pupfinder2/');
} else {
  define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
}


include_once('DatabaseConnection.php');
$db = new DatabaseConnection;
include_once(__DIR__ . '/../codes/authentication_code.php');

function base_url($slug){
    echo SITE_URL.$slug;
}

function validateInput($dbcon, $input){
    return mysqli_real_escape_string($dbcon, $input);
}

function redirect($message, $page){
    $redirectTo = SITE_URL . $page;
    $_SESSION['message'] = "$message";
    header("Location: $redirectTo");
    exit(0);
}
?>