<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'pupfinder');
define('DB_PORT', '3307');

//For hosting.
// define('DB_HOST', $_ENV['DB_HOST'] );
// define('DB_USER', $_ENV['DB_USER'] );
// define('DB_PASSWORD', $_ENV['DB_PASSWORD'] );
// define('DB_DATABASE', $_ENV['DB_DATABASE'] );
// define('DB_PORT', $_ENV['DB_PORT']);

// define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/pupfinder/');


include_once('DatabaseConnection.php');
$db = new DatabaseConnection;
include_once(__DIR__ . '/../codes/authentication_code.php');

function base_url($slug){
     return SITE_URL.$slug;
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