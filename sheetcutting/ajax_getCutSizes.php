<?php
$server = 'localhost';
$user = 'Fablabian';
$password = 'sbVaBEd3eW9dxmdb';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}
/*
foreach ($_POST as $param_name => $param_val) {
    echo "Param: $param_name; Value: $param_val<br />\n";
}
*/


$sql = "SELECT DISTINCT height, width FROM cut_sizes h INNER JOIN VARIANTS v on h.type_id = v.type_id WHERE name='".$_POST["name"]."' ORDER BY name ASC";
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		echo $row["height"] . "x" . $row["width"] . ',';
	}
}

$connection->close();
 ?>