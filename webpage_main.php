<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
.left_panel {
	float:left;
	width:15%;
	height:80%;
	border-style:solid;
	border-width:1px;
	margin-right:2px;
}
.right_panel {
	float:left;
	width:84%;
	height:80%;
	overflow:auto;
}
tr {
	background-color:#dddddd;
}
<?php include 'ui_buttons_style.php' ?> 
</style>
<body>
<div style="height:18%"> 
	<?php include 'ui_titlebar.php' ?> 
</div>
<div class="left_panel">
	<?php include 'ui_buttons.php' ?> 
</div>
<div class="right_panel">
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

initSheetTable_TEMP($connection);
//$cutListTest = new CutList('SIZE:35x20,price:90.00,count:5;size:20x20,price:60.5345,count:2');
//consoleLog($cutListTest->stringify());

$connection->close();
?>
</div>
</body>
</html>