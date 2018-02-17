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

$table_data = explode(',', file_get_contents('php://input')); // Information passed from javascript.
$variants = unserialize($_SESSION['variants']);

$material_name = $table_data[0];
$table_width = $table_data[1];
$table_height = $table_data[2];
$table_data_start_offset = 3;

$sheet_data = getSheetFromMaterialNameAsAnObject($connection, $material_name);
$cutlist = getCutListEntriesAsAn2DArray($connection, $sheet_data->cutlist_id);
$cutlist_indices = getCutListIndices($cutlist, $table_data, $table_data_start_offset + 1, $table_height - 1);
//print_r($variants);
for($i = 1; $i < $table_width; $i++) {
	$inventory_indices = explode(',' , getSheetVariantInventoryIndicesAsAnArrayString($connection, $variants[$i - 1][2]));
	for($j = 1; $j < $table_height; $j++) {
		$table_offset = ($table_height * $i) + $j + $table_data_start_offset;
		updateRecord($connection, $inventory_indices[$j - 1], $cutlist_indices[$j - 1], $table_data[$table_offset]);
	}
}

function updateRecord($connection, $index, $cutlist_index, $set_count_value){
	$sql = 'UPDATE SheetInventoryEntry SET `count` = ' . $set_count_value . ' WHERE `index` = ' . $index 
	. ' AND `cutlistentry_index` = ' . $cutlist_index;
	
	//echo 'Updating record: (' . $index . ',' . $cutlist_index . ') as value: ' . $set_count_value;
	
	$result = mysqli_query($connection, $sql);
	
	if($result)
		return " Record updated! ";
	else
		return " Record update FAILED! ";
}

function getCutListIndices($cutlist, $table_data, $offset, $length){
	$indices = array();
	for($i = 0; $i < $length; $i++) {
		$size = explode(' x ',$table_data[$offset + $i]);
		$found = false;
		foreach($cutlist as $cutlist_entry) {
			$entry_length = $cutlist_entry[1];
			$entry_width = $cutlist_entry[2];
			if($entry_length == $size[0] && $entry_width == $size[1]) {
				$found = true;
				array_push($indices, $cutlist_entry[0]);
				break;
			}
		}
		if(!$found) {
			array_push($indices, -1); // add -1 to list if no index was found.
		}
	}
	return $indices;
}

?>