<?php
include 'functions_util.php';
include 'functions_database_sheets.php';

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'test_database';

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

// This code will take the JSON data sent from POST, and put it in a session variable.
session_start();
$POST_INPUT = file_get_contents('php://input');
$input = explode(',', $POST_INPUT); // material,variant
$material_id = $input[0];
$variant_id = $input[1];

$connection->close();

echo $POST_INPUT;
?>