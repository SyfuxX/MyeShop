<?php

// open the session
session_start ();

$dns = 'mysql:host=localhost; dbname=eshop';
$user = 'root';
$pass = '';
$attr = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$con = new PDO ($dns, $user, $pass, $attr);

// CONSTANT
define ('URL', 'http://localhost/PHP/6.eshop/');
define ('ROOT_TREE', $_SERVER['DOCUMENT_ROOT'] . '/PHP/6.eshop/');
// We just declared the way to access our files + URL

//>> declare VARIABLES
$msg_error = "";
$page = "";
$content = "";

require_once ('functions.php');

?>