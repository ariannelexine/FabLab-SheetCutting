<?php
function getSheetFromMaterialNameAsAnObject($connection, $material_name){
	$sql = 'SELECT * from Sheets WHERE `description` = \'' . $material_name . '\' LIMIT 1';
	$result = mysqli_query($connection, $sql);
	return mysqli_fetch_object($result);
}

function getVariantsOfSheetAsAn2DArray($connection, $variants_id) {
	$cutlist = array();
	$sql = 'SELECT indices from Variants WHERE `variants_id` = ' . $variants_id . ' LIMIT 1';
	$result = mysqli_query($connection, $sql);
	$sql = 'SELECT * from Variant WHERE `variant_id` IN (' . $result->fetch_assoc()['indices'] . ')';
	$result_entries = mysqli_query($connection, $sql);
	return mysqli_fetch_all($result_entries);
}

function getCutListEntriesAsAn2DArray($connection, $cutlist_id){
	$cutlist = array();
	$sql = 'SELECT indices from CutList WHERE `cutlist_id` = ' . $cutlist_id . ' LIMIT 1';
	$result = mysqli_query($connection, $sql);
	$sql = 'SELECT * from CutListEntry WHERE `index` IN (' . $result->fetch_assoc()['indices'] . ')';
	$result_entries = mysqli_query($connection, $sql);
	return mysqli_fetch_all($result_entries);
}

function getSheetVariantInventoryIndicesAsAnArrayString($connection, $sheetinv_id) {
	$sql = 'SELECT indices from SheetInventory WHERE `sheetinv_id` = ' . $sheetinv_id . ' LIMIT 1';
	$result = mysqli_query($connection, $sql);
	return $result->fetch_assoc()['indices'];
}

function getSheetVariantInventoryEntriesAsAn2DArray($connection, $sheetinv_id){
	$cutlist = array();
	$indices = getSheetVariantInventoryIndicesAsAnArrayString($connection, $sheetinv_id);
	$sql = 'SELECT * from SheetInventoryEntry WHERE `index` IN (' . $indices . ')';
	$result_entries = mysqli_query($connection, $sql);
	return mysqli_fetch_all($result_entries);
}

?>