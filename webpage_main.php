<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	min-width:1000px;
	overflow: hidden;
}
.right_panel {
	float:left;
	width:84%;
	min-width:100px;
	height:80%;
	overflow:auto;
	margin: 2px;
	text-align:center;
}
<?php include 'ui_buttons_style.php' ?> 
</style>
<body>

<?php include 'ui_titlebar.php' ?> 
<?php include 'ui_buttons.php' ?> 

<div class="right_panel">
<h1> Welcome to the FabLab Kilns web-app demo! </h1>
<h3> Select a page on the left side to perform an action. </h3>

<?php
include 'functions_database_init_TEMP.php';
include 'class_CutList.php';

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'test_database';

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

initDatabase($connection);

$connection->close();
?>
</div>
</body>
</html>