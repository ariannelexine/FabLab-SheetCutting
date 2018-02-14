<?php

function getVariantNamesOfSheet($connection, $sheet_id) {
	$sql = 'SELECT variants_id from Sheets WHERE sheet_id = ' . $sheet_id;
	$result = mysqli_query($connection, $sql);
	$num_rows = mysqli_num_rows($result);
	$values = array();
	if($num_rows > 0) {
		while($row = $result->fetch_assoc()){
			$sql = 'SELECT indices from Variants';
			$result2 = mysqli_query($connection, $sql);
			$num_rows2 = mysqli_num_rows($result2);
			if($num_rows2 > 0) {
				while($row2 = $result2->fetch_assoc()){
					$variant_indices = explode(',', $row2['indices']);
					foreach($variant_indices as $variant_index) {
						$sql = 'SELECT name from Variant WHERE variant_id = ' . $variant_index;
						$result3 = mysqli_query($connection, $sql);
						$num_rows3 = mysqli_num_rows($result3);
						if($num_rows3 > 0) {
							while($row3 = $result3->fetch_assoc()){
								array_push($values, $row3['variant_id'].','.$row3['name'].','.$row3['sheetinv_id']);
							}
						}
					}
				}
			}
		}
	}
	return $values;
}

function getSheetInventoryIDFromVariant($connection, $material_name, $variant_name) {
	$sql = 'SELECT variants_id from Sheets WHERE description= ' . $material_name;
	
	$result = mysqli_query($connection, $sql);
	$num_rows = mysqli_num_rows($result);
	$values = array();
	if($num_rows > 0) {
		$row = $result->fetch_assoc();
		$sql = 'SELECT indices from Variants WHERE variants_id=' . $row['variants_id'];
		$result = mysqli_query($connection, $sql);
		$num_rows = mysqli_num_rows($result);
		if($num_rows > 0)
		{
			$row = $result->fetch_assoc();
		}
	}
	return $values;
}

?>