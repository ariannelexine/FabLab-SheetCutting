<?php
require 'functions_util.php';

// Returns true if a table with a given name exists in the database.
function doesTableExist($connection, $table_name) {
	return $connection->query('SELECT 1 from ' . $table_name . ' LIMIT 1') !== FALSE;
}

// Create a new table in a database
function makeNewTable($connection, $table_name, $table_rows) {
	$sql = 'CREATE TABLE ' . $table_name . $table_rows;
	consoleLog('sql = ' . $sql);
	if($connection->query($sql) === FALSE){
		consoleLog('Table \'' . $table_name . '\' could not be created. Error: ' . $connection->error);
	}
}

// Create a new record into the database
function addRecordIntoTable($connection, $table_name, $row_names, $values) {
	$sql = 'INSERT INTO ' . $table_name . ' ' . $row_names . ' VALUES ' . $values;
	consoleLog('sql = ' . $sql);
	if($connection->query($sql) === FALSE){
		consoleLog('New record in table \'' . $table_name . '\' could not be created. Error: ' . $connection->error);
	}
}

// Creates new records in the database
function addMultipleRecordsIntoTable($connection, $table_name, $row_names, $values_array) {
	foreach($values_array as $values){
		addRecordIntoTable($connection, $table_name, $row_names, $values);
	}
}

// Removes a table from the database
function deleteTable($connection, $table_name) {
	$sql = 'DROP TABLE ' . $table_name;
	consoleLog('sql = ' . $sql);
	if($connection->query($sql) === FALSE){
		consoleLog('Table \'' . $table_name . '\' could not be dropped. Error: ' . $connection->error);
	}
}

// Removes all records from a table in the database
function clearTable($connection, $table_name) {
	$sql = 'DELETE FROM ' . $table_name;
	consoleLog('sql = ' . $sql);
	if($connection->query($sql) === FALSE){
		consoleLog('Table \'' . $table_name . '\' could not be cleared. Error: ' . $connection->error);
	}
}

// Removes records based on the "WHERE" clause.
function removeRecordsFromTable($connection, $table_name, $where_string){
	$sql = 'DELETE FROM ' . $table_name . ' WHERE ' . $where_string;
	consoleLog('sql = ' . $sql);
	if($connection->query($sql) === FALSE){
		consoleLog('Records from table \'' . $table_name . '\' could not be deleted. Error: ' . $connection->error);
	}
}

// Returns an array of items from a given column name in a table.
function getTableCollumnEntries($connection, $table_name, $column_name){
	$sql = 'SELECT * from ' . $table_name;
	$result = mysqli_query($connection, $sql);
	$num_rows = mysqli_num_rows($result);
	$values = array();
	if($num_rows > 0) {
		while($row = $result->fetch_assoc()){
			array_push($values, $row[$column_name]);
		}
	}
	return $values;
}

function echoTable($connection, $table_name){
	$sql = 'SHOW COLUMNS FROM ' . $table_name;
	$result = $connection->query($sql);
	$column_names = array();
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($column_names, $row['Field']);
		}
	}
	else {
		return;
	}
	
	echo '<table style="width:100%" border="1px solid black"><tr><th>' . $table_name . '</th></tr></table>';
	echo '<table style="width:100%" border="1px solid black">';
	echo '<tr>';
	foreach($column_names as $column_name){
		echo '<th>' . $column_name . '</th>';
	}
	echo '</tr>';
	
	$sql = 'SELECT * from ' . $table_name;
	$result = mysqli_query($connection, $sql);
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0) {
		while($row = $result->fetch_assoc()){
			echo '<tr>';
			foreach($column_names as $column_name){
				echo '<td>' . $row[$column_name] . '</td>';
			}
			echo '</tr>';
		}
	}
	

	echo '</table><br>';
}

?>