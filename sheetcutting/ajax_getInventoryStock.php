<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$sql = "SELECT DISTINCT type, c.cut_id, v.variant_id, v.colorhex, name, width, height, price, count(obj_id) as 'In Stock'
FROM sheet_type s
LEFT JOIN cut_sizes as c ON s.type_id = c.type_id
LEFT JOIN variants as v ON s.type_id = v.type_id
LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id AND i.cut_id = c.cut_id
WHERE i.removed_date IS NULL AND name = '".$_POST["name"]."' AND height = '".$_POST["height"]."' AND width = '".$_POST["width"]."';";

if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		echo $row['In Stock'] . ',' . $row['price'] . ',' . $row['cut_id'];
	}
}

$connection->close();
 ?>