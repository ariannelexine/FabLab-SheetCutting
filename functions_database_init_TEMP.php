<?php
include 'functions_database_modify.php';

function initSheetTable_TEMP($connection) {
	// Delete tables if they already exist.
	deleteTable($connection, 'Sheets');
	deleteTable($connection, 'Variants');
	deleteTable($connection, 'Variant');
	deleteTable($connection, 'SheetInventory');
	deleteTable($connection, 'SheetInventoryEntry');
	deleteTable($connection, 'CutList');
	deleteTable($connection, 'CutListEntry');
	
	// Create Sheets table
	makeNewTable($connection, 'Sheets', '(
		`sheet_id` SMALLINT PRIMARY KEY, 
		`description` VARCHAR(20000) NOT NULL, 
		`variants_id` SMALLINT,
		`cutlist_id` SMALLINT
	)');
	$values_array = array(
		'(0, "Glass", 0, 0)'
	);
	addMultipleRecordsIntoTable($connection, 'Sheets', '(`sheet_id`, `description`, `variants_id`, `cutlist_id`)', $values_array);
	
	// Create variants table
	makeNewTable($connection, 'Variants', '(
		`variants_id` SMALLINT PRIMARY KEY, 
		`indices` VARCHAR(20000) NOT NULL
	)');
	$values_array = array(
		'(0, "0,1,2,3,4")'
	);
	addMultipleRecordsIntoTable($connection, 'Variants', '(`variants_id`, `indices`)', $values_array);
	
	// Create variant table
	makeNewTable($connection, 'Variant', '(
		`variant_id` SMALLINT PRIMARY KEY, 
		`name` VARCHAR(20000) NOT NULL,
		`sheetinv_id` SMALLINT
	)');
	$values_array = array(
		'(0, "Clear", 0)',
		'(1, "Red", 1)',
		'(2, "Green", 2)',
		'(3, "Blue", 3)',
		'(4, "Yellow", 4)'
	);
	addMultipleRecordsIntoTable($connection, 'Variant', '(`variant_id`, `name`, `sheetinv_id`)', $values_array);
	
	// Create sheet inventory table
	makeNewTable($connection, 'SheetInventory', '(
		`sheetinv_id` SMALLINT PRIMARY KEY, 
		`indices` VARCHAR(20000) NOT NULL
	)');
	$values_array = array(
		'(0, "0,1,2")',
		'(1, "4,5,6")',
		'(2, "7,8,9")',
		'(3, "10,11,12")',
		'(4, "13,14,15")',
	);
	addMultipleRecordsIntoTable($connection, 'SheetInventory', '(`sheetinv_id`, `indices`)', $values_array);
	
	// Create sheet inventory entry table
	makeNewTable($connection, 'SheetInventoryEntry', '(
		`index` INT PRIMARY KEY, 
		`cutlistentry_index` INT,
		`count` SMALLINT
	)');
	$values_array = array(
		// Inventory for clear glass
		'(0, 0, 5)',
		'(1, 1, 1)',
		'(2, 2, 2)',
		
		// Inventory for red glass
		'(3, 0, 5)',
		'(4, 1, 0)',
		'(5, 2, 0)',
		
		// Inventory for green glass
		'(6, 0, 5)',
		'(7, 1, 0)',
		'(8, 2, 0)',
		
		// Inventory for blue glass
		'(9, 0, 5)',
		'(10, 1, 0)',
		'(11, 2, 0)',
		
		// Inventory for yellow glass
		'(12, 0, 5)',
		'(13, 1, 0)',
		'(14, 2, 0)'
	);
	addMultipleRecordsIntoTable($connection, 'SheetInventoryEntry', '(`index`, `cutlistentry_index`, `count`)', $values_array);
	
	// Create CutList table
	makeNewTable($connection, 'CutList', '(
		`cutlist_id` SMALLINT PRIMARY KEY, 
		`indices` VARCHAR(20000) NOT NULL
	)');
	$values_array = array(
		'(0, "0,1,2")'
	);
	addMultipleRecordsIntoTable($connection, 'CutList', '(`cutlist_id`, `indices`)', $values_array);
	
	// Create CutListEntry table
	makeNewTable($connection, 'CutListEntry', '(
		`index` INT PRIMARY KEY, 
		`width` SMALLINT,
		`height` SMALLINT,
		`cost` DECIMAL
	)');
	$values_array = array(
		'(0, 35, 20, 100.0)',
		'(1, 20, 20, 80.0)',
		'(2, 5, 5, 20.0)'
	);
	addMultipleRecordsIntoTable($connection, 'CutListEntry', '(`index`, `width`, `height`, `cost`)', $values_array);
	
	// Draw tables to webpage
	echoTable($connection, 'Sheets');
	echoTable($connection, 'Variants');
	echoTable($connection, 'Variant');
	echoTable($connection, 'SheetInventory');
	echoTable($connection, 'SheetInventoryEntry');
	echoTable($connection, 'CutList');
	echoTable($connection, 'CutListEntry');
}

?>