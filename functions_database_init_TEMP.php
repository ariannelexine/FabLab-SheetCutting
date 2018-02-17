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
		'(0, "0,1,2,3,4,5,6,7")',
		'(1, "8,9,10,11,12,13,14,15")',
		'(2, "16,17,18,19,20,21,22,23")',
		'(3, "24,25,26,27,28,29,30,31")',
		'(4, "32,33,34,35,36,37,38,39")',
	);
	addMultipleRecordsIntoTable($connection, 'SheetInventory', '(`sheetinv_id`, `indices`)', $values_array);
	
	// Create sheet inventory entry table
	makeNewTable($connection, 'SheetInventoryEntry', '(
		`index` INT PRIMARY KEY, 
		`cutlistentry_index` INT,
		`count` MEDIUMINT UNSIGNED
	)');
	$values_array = array(
		// Inventory for clear glass
		'(0, 0, 5)',
		'(1, 1, 1)',
		'(2, 2, 2)',
		'(3, 3, 2)',
		'(4, 4, 4)',
		'(5, 5, 2)',
		'(6, 6, 1)',
		'(7, 7, 0)',
		
		// Inventory for red glass
		'(8, 0, 4)',
		'(9, 1, 2)',
		'(10, 2, 4)',
		'(11, 3, 2)',
		'(12, 4, 1)',
		'(13, 5, 1)',
		'(14, 6, 1)',
		'(15, 7, 2)',
		
		// Inventory for green glass
		'(16, 0, 5)',
		'(17, 1, 2)',
		'(18, 2, 2)',
		'(19, 3, 3)',
		'(20, 4, 0)',
		'(21, 5, 2)',
		'(22, 6, 3)',
		'(23, 7, 4)',
		
		// Inventory for blue glass
		'(24, 0, 1)',
		'(25, 1, 0)',
		'(26, 2, 0)',
		'(27, 3, 2)',
		'(28, 4, 4)',
		'(29, 5, 6)',
		'(30, 6, 2)',
		'(31, 7, 4)',
		
		// Inventory for yellow glass
		'(32, 0, 8)',
		'(33, 1, 0)',
		'(34, 2, 0)',
		'(35, 3, 0)',
		'(36, 4, 0)',
		'(37, 5, 0)',
		'(38, 6, 0)',
		'(39, 7, 0)'
	);
	addMultipleRecordsIntoTable($connection, 'SheetInventoryEntry', '(`index`, `cutlistentry_index`, `count`)', $values_array);
	
	// Create CutList table
	makeNewTable($connection, 'CutList', '(
		`cutlist_id` SMALLINT PRIMARY KEY, 
		`indices` VARCHAR(20000) NOT NULL
	)');
	$values_array = array(
		'(0, "0,1,2,3,4,5,6,7")'
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
		'(0, 35, 20, 50.0)',
		'(1, 20, 20, 40.0)',
		'(2, 20, 15, 35.0)',
		'(3, 20, 10, 30.0)',
		'(4, 10, 15, 25.0)',
		'(5, 10, 10, 20.0)',
		'(6, 10, 5, 15.0)',
		'(7, 5, 5, 10.0)'
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