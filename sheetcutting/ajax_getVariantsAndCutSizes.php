<?php
include('ajax_connectToDatabase.php');
$send_data = [];


$variants = []; // used for cut_sizes
$sql = "SELECT name, variant_id from Variants v INNER JOIN sheet_type s on v.type_id = s.type_id WHERE s.type='".$_POST["sheet_name"]."'";
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		$entry = $row["name"];
		if($row["variant_id"] != NULL) {
			$entry .= ' (' . $row["variant_id"] . ')';
		}
		array_push($variants, $entry);
	}
}
array_push($send_data, $variants);

// Get list of cutsizes
$cut_sizes = [];
$cut_sizes_stock = [];
$sql = "
SELECT width, height, price
FROM cut_sizes c 
LEFT JOIN sheet_type s on c.type_id = s.type_id 
WHERE s.type='".$_POST["sheet_name"]."'
GROUP BY width, height";
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		$entry = $row["width"] . "x" . $row["height"];
		
		array_push($cut_sizes, $entry); // push size
	}
}
array_push($send_data, $cut_sizes);

echo json_encode($send_data);

$connection->close();
 ?>