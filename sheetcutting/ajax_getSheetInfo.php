<?php
include('ajax_connectToDatabase.php');

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$sql ="SELECT * FROM variants WHERE type_id = ".$_POST["sheet_type"]." ORDER BY name ASC;";
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
        echo("<option value='$row[variant_id]'>$row[name]</option>");
	}
}

$sql1 ="SELECT * FROM cut_sizes WHERE type_id = ".$_POST["sheet_type"].";";
echo("cuts");
if ($result = $connection->query($sql1)) {
	while ($row = $result->fetch_assoc() ){
        echo("<option value='$row[cut_id]'>$row[width]x$row[height]</option>");
	}
}

$connection->close();
 ?>