<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$sql = "SELECT DISTINCT sheet_type, description, name, height, width, price, count(obj_id) as 'In Stock'
FROM SHEETS h 
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
LEFT JOIN SHEET_INVENTORY s on s.variant_id = h.variant_id and s.size = h.size
WHERE sheet_type = '".$_POST["sheet_type"]."' AND name = '".$_POST["name"]."' AND height = '".$_POST["height"]."' AND width = '".$_POST["width"]."';";

if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		//print_r($row);
		echo $row['In Stock'] . ', price = $' . $row['price'];
	}
}

$connection->close();
 ?>