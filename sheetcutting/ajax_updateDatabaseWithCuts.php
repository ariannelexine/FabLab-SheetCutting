<?php
include('ajax_connectToDatabase.php');
include('class_sheet.php');
session_start();

// $_SESSION["Cuts"] = [$list, $cut_into]
$data = unserialize($_SESSION["Cuts"]);
$inv_data = json_decode($_SESSION["inv_data"], true);
$list = $data[0];
$cut_into = $data[1];

$staff_id = $_SESSION["staff_id"];
$trans_id = getTransactionID($staff_id);

$list_length = count($list);
for($i = $list_length - 1; $i >= 0; $i--){
	//echo $list[$i]->width . 'x' . $list[$i]->height . '\n';
	$cur_sheet = $list[$i];
	removeSheetFromInventory($connection, $cur_sheet, $trans_id, $staff_id);
	$cur_sheet_children_cuts = $cut_into[$i]; // contains array of ["child_id"],$row["amount"]
	$num_children = count($cur_sheet_children_cuts);
	for($j = 0; $j < $num_children; $j++) {
		$child_sheet = getInventoryByCutId($inv_data, $cut_into[$i][$j][0]);
		// Add child sheet to inventory
		addChildSheetToInventory($connection, $child_sheet);
	}
	
}

function getTransactionID($staff_id) {
	global $mysqli;

	if ($mysqli->query("
		INSERT INTO sheet_transaction
		  (`staff_id`,`removed_date`) 
		VALUES
		  ('$staff_id', CURRENT_TIMESTAMP);
	")){
		return $mysqli->insert_id;
	} else {
		return $mysqli->error;
	}
}

function getInventoryByCutId($inv_data, $id){
	$keys = array_keys($inv_data);
	foreach($keys as $key){
		if($inv_data[$key]['cut_id'] == $id)
			return $inv_data[$key];
	}
	return null;
}

function addChildSheetToInventory($connection, $sheet) {
	$variant_id = $sheet['variant_id'];
	$cut_id = $sheet['cut_id'];
	$sql_insert = "INSERT INTO sheet_inventory (variant_id, cut_id) VALUES ($variant_id, $cut_id);";
	echo $sql_insert;
	if ($result = $connection->query($sql_insert)) {
		echo 'Added sheet! ';
	} else {
		echo 'Added sheet failed! ';
	}
}

function removeSheetFromInventory($connection, $sheet, $trans_id, $staff_id) {
	$sql_get_objId = "
	SELECT * 
	FROM sheet_inventory
	WHERE obj_id = 
	(SELECT max(obj_id)
	FROM sheet_inventory s
	WHERE variant_id = '".$sheet->id."' AND cut_id = ".$sheet->cut_id.");";
	if ($result = $connection->query($sql_get_objId)) {
		while ($row = $result->fetch_assoc()) {
			$obj_id = $row['obj_id'];
			$sql_update = 
			"UPDATE sheet_inventory 
			SET trans_id = $trans_id
			WHERE obj_id = $obj_id;";
			
			if ($result2 = $connection->query($sql_update)) {
				echo 'Removed sheet! ';
			} else {
				echo 'Removed sheet failed! ';
			}
		}
	} else {
		echo 'Get obj id failed! ';
	}
}



$connection->close();
 ?>