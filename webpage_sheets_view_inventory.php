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
	margin: 2px;
}
<?php include 'ui_buttons_style.php' ?> 
</style>
<script>
// Javascript code

function callPHP(url) {
    var post = new XMLHttpRequest();
    post.open("POST", url);

	var material = document.getElementById("dropDown_material");
	var variant = document.getElementById("dropDown_variant");
	
	
    post.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
    post.onreadystatechange = function() { 
		if(post.readyState == 4 && post.status == 200) {
			alert(post.responseText);
        }
    }
    post.send(material.selectedIndex + "," + variant.selectedIndex);
}
</script>
<body>
<div style="height:18%"> 
	<?php include 'ui_titlebar.php' ?> 
</div>
<div class="left_panel">
	<?php include 'ui_buttons.php' ?> 
</div>
<div class="right_panel">
<h2 style="margin-top:0px;">Inventory</h2>
<?php
include 'functions_database_modify.php';
include 'functions_database_sheets.php';

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'test_database';

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

// Create drop down list
echo 'Select material: <select id="dropDown_material" onchange="callPHP(\'ajax_get_inventory_table.php\');">';
$names = getTableCollumnEntries($connection, 'Sheets', 'description');
foreach($names as $name){
	echo '<option value = "' . $name . '">' . $name;
}
echo '</select>';
echo ' Variant: <select id="dropDown_variant" onchange="callPHP(\'ajax_get_inventory_table.php\');">';
$variants = getVariantNamesOfSheet($connection, 0);
foreach($variants as $variant){
	$variants_name = explode(',', $variant)[1];
	echo '<option value = "' . $variant . '">' . $variant;
}
echo '</select>';



$connection->close();
?>
</div>
<script>
	callPHP("ajax_get_inventory_table.php");
</script>
</body>
</html>