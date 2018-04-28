<?php
// $server = 'localhost';
// $user = 'root';
// $password = '';
// $database = 'fabapp-v0.9';
// $connection = mysqli_connect($server, $user, $password, $database);
// if ($connection->connect_error) {
// 	exit('Connection failed: ' . $connection->connect_error);
// }

$server = 'localhost';
$user = 'Fablabian';
$password = 'sbVaBEd3eW9dxmdb';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$mysqli = new mysqli('localhost', 'Fablabian', 'sbVaBEd3eW9dxmdb', 'fabapp-v0.9') or die(mysql_error());

?>