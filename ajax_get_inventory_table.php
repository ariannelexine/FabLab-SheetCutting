<?php
session_start();
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

$material_name = file_get_contents('php://input'); // Information passed from javascript.

$variants = unserialize($_SESSION['variants']);

$sheet_data = getSheetFromMaterialNameAsAnObject($connection, $material_name);
$cutlist = getCutListEntriesAsAn2DArray($connection, $sheet_data->cutlist_id);
$inventory = array();

echo '<br/><table style="width:100%" border="1px solid black"><tr><th>' . $material_name . '</th></tr></table>';

echo '<table id="inventory_table" style="width:100%;table-layout:fixed;" border="1px solid black">';

// Column names
echo '<tr>';
echo '<th style="width:10%;">(Size)</th>'; // Sizes collumn
foreach($variants as $variant){
	$inventory[$variant[1]] = getSheetVariantInventoryEntriesAsAn2DArray($connection, $variant[2]);
	echo '<th>' . $variant[1] . '</th>';
}
echo '</tr>';

foreach($cutlist as $cutlistentry) {
	$cut_index = $cutlistentry[0];
	$cut_width = $cutlistentry[1];
	$cut_height = $cutlistentry[2];
	echo '<tr>';
	echo '<th style="width:10%;">'.$cut_width.' x '.$cut_height.'</th>'; // Size
	foreach($variants as $variant){
		echo '<td class="count" align="center">' . getInventoryCountFromVariant($cut_index, $inventory[$variant[1]]) . '</td>';
	}
	echo '</tr>';
}

echo '</table>';

echo '<a href="javascript:switchToEditMode()" id="edit_button" class="ui_button ui_edit_button" style="width:15%;margin-top:8px;">Edit</a> ';
echo '<a href="javascript:switchBackFromEditMode_Save()" id="save_button" class="ui_button ui_save_button" style="width:15%;margin-top:8px;display:none;">Save</a> ';
echo '<a href="javascript:switchBackFromEditMode_Cancel()" id="close_button" class="ui_button ui_close_button" style="width:15%;margin-top:8px;display:none;">Cancel</a> ';

$connection->close();

function getInventoryCountFromVariant($cut_index, $variant_inventory) {
	foreach($variant_inventory as $variant_inv_entry) {
		$variant_cut_index = $variant_inv_entry[1];
		if($variant_cut_index == $cut_index){
			return $variant_inv_entry[2]; // return count;
		}
	}
	return '<span style="color:red;">ERROR: NOMATCH</span>';
}
?>