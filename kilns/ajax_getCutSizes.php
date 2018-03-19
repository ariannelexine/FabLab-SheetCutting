<?php
$server = 'localhost';
$user = 'root';
$password = '';
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

$sql = "SELECT DISTINCT height, width FROM SHEETS h INNER JOIN VARIANTS v on h.variant_id = v.variant_id INNER JOIN CUT_SIZES c on h.size = c.cut_id WHERE name='".$_POST["name"]."' AND sheet_type='".$_POST['sheet_type']."'";
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		echo $row["height"] . "x" . $row["width"] . ',';
	}
}

$connection->close();
 ?>