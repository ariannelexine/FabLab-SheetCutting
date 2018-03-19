<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$sql = "SELECT * 
FROM SHEET_INVENTORY
WHERE obj_id = (SELECT max(obj_id)
FROM SHEET_INVENTORY s
INNER JOIN SHEETS h on s.variant_id = h.variant_id and s.size = h.size
INNER JOIN VARIANTS v on h.variant_id = v.variant_id
INNER JOIN CUT_SIZES c on h.size = c.cut_id
WHERE sheet_type = '".$_POST["sheet_type"]."' AND name = '".$_POST["name"]."' AND height = '".$_POST["height"]."' AND width = '".$_POST["width"]."');";

if ($result = $connection->query($sql)) {
	$num_deleted = 0;
	while ($row = $result->fetch_assoc() ){
		
		$sql2 = "DELETE FROM SHEET_INVENTORY WHERE obj_id = " . $row["obj_id"] . ";";
		
		if ($result2 = $connection->query($sql2)) {
			echo 'obj_id ' . $row["obj_id"] . ' was deleted';
		} else {
			echo 'obj_id ' . $row["obj_id"] . ' was NOT removed';
		}
		
		$num_deleted++;
	}
	if($num_deleted == 0) {
		echo 'No items were changed!';
	}
}
//echo 'Removed item from database!';
$connection->close();
 ?>