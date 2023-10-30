<?php 

require_once 'config.php';

// connect to database
$mysqli = new mysqli($host, $user, $pass, 'mysql');
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}