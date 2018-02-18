<!DOCTYPE html>
<html>
<?php session_start()?>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
.right_panel {
	float:left;
	width:84%;
	height:80%;
	overflow:auto;
	margin: 2px;
	text-align:center;
}
table {
	background-color:#F4F4F4;
}
<?php include 'ui_buttons_style.php' ?> 
</style>
<script> 
// Javascript code

function callPHP(url, params, callback_function) {
    var post = new XMLHttpRequest();
    post.open("POST", url);

    post.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
    post.onreadystatechange = function() { 
		if(post.readyState == 4 && post.status == 200) {
			callback_function(post.responseText);
        }
    }
    post.send(params);
}

function updateTable() {
	var material = document.getElementById("dropDown_material");
	var output = document.getElementById("output_html");
	callPHP("ajax_get_inventory_table.php", material.value, function(responseText) {
		output.innerHTML = responseText;
	});
}

function saveTable() {
	var material = document.getElementById("dropDown_material");
	var output = document.getElementById("output_html");
	var table = document.getElementById("inventory_table");
	var height = table.rows.length;
	var width = table.rows[0].cells.length;
	var params_table = new Array(width * height); // allocate array with fixed size
	
	for(var i = 0; i < height; i++){
		for(var j = 0; j < width; j++){
			params_table[(j * height) + i] = table.rows[i].cells[j].textContent;
		}
	}
	
	var params = material.value + ',' + width + ',' + height + ',' + params_table.join(',');
	callPHP("ajax_save_inventory_table.php", params, function(responseText){
		//alert(responseText);
	});
}

function validateTextInput(event) {
	return event.charCode >= 48 && event.charCode <= 57; // Check if typing a number only.
}

var saved_table_html = "";
function switchToEditMode() {
	saved_table_html = document.getElementById("inventory_table").innerHTML;
	
	var elements = document.getElementsByClassName('count');
	for(var i = 0; i < elements.length; i++) {
		var previous = elements[i].innerHTML;
		elements[i].innerHTML = "<input maxLength=\"7\" onkeypress=\"return validateTextInput(event)\" type=\"text\" style=\"width:98%\"type=\"text\" value=\"" + previous + "\"/>";
	}
	
	var edit_button = document.getElementById("edit_button");
	var save_button = document.getElementById("save_button");
	var close_button = document.getElementById("close_button");
	var dropdown = document.getElementById("dropDown");
	var header = document.getElementById("sheet_inv_header");
	
	header.style.marginBottom = "0px";
	dropdown.style.display = "none";
	edit_button.style.display = "none";
	save_button.style.display = "inline-block";
	close_button.style.display = "inline-block";
}

function switchBackFromEditMode_Save() {
	var elements = document.getElementsByClassName('count');
	for(var i = 0; i < elements.length; i++) {
		var value = elements[i].children[0].value;
		if(isNaN(value)) 
			value = 0; // If the input value is not a number, make it zero.
		elements[i].innerHTML = value;
	}
	
	saveTable();
	
	var edit_button = document.getElementById("edit_button");
	var save_button = document.getElementById("save_button");
	var close_button = document.getElementById("close_button");
	var dropdown = document.getElementById("dropDown");
	var header = document.getElementById("sheet_inv_header");
	
	header.style.marginBottom = "20px";
	dropdown.style.display = "inline-block";
	edit_button.style.display = "inline-block";
	save_button.style.display = "none";
	close_button.style.display = "none";
}

function switchBackFromEditMode_Cancel() {
	var main_table = document.getElementById("inventory_table");
	main_table.innerHTML = saved_table_html;
	
	var edit_button = document.getElementById("edit_button");
	var save_button = document.getElementById("save_button");
	var close_button = document.getElementById("close_button");
	var dropdown = document.getElementById("dropDown");
	var header = document.getElementById("sheet_inv_header");
	
	header.style.marginBottom = "20px";
	dropdown.style.display = "inline-block";
	edit_button.style.display = "inline-block";
	save_button.style.display = "none";
	close_button.style.display = "none";
}
</script>
<body>

<?php include 'ui_titlebar.php' ?> 
<?php include 'ui_buttons.php' ?> 

<div class="right_panel">
<h2 id="sheet_inv_header" style="margin-top:0px;">Sheet Inventory</h2>

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
echo '<span id="dropDown">Select material: <select id="dropDown_material" onchange="updateTable()">';
$names = getTableCollumnEntries($connection, 'Sheets', 'description');
foreach($names as $name){
	echo '<option value = "' . $name . '">' . $name;
}
echo '</select></span>';

$variants = getVariantsOfSheetAsAn2DArray($connection, 0);

$_SESSION['variants'] = serialize($variants); // Save variants to session

echo '<div id="output_html"></div>';

$connection->close();
?>
</div>
<script>
	updateTable();
</script>
</body>
</html>