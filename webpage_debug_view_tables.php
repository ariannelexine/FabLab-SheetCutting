<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
.right_panel {
	float:left;
	width:84%;
	height:82%;
	overflow:auto;
	margin: 2px;

}
<?php include 'ui_buttons_style.php' ?> 
</style>
<body>

<?php include 'ui_titlebar.php' ?> 
<?php include 'ui_buttons.php' ?> 

<div class="right_panel">

<?php
include 'functions_database_init_TEMP.php';

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'test_database';

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

viewSheetTables($connection);

$connection->close();
?>
</div>
</body>
</html>