<?php
include('ajax_connectToDatabase.php');

$sql = "
SELECT width, height, count(obj_id) as 'In Stock'
FROM sheet_type s
LEFT JOIN variants as v ON s.type_id = v.type_id
LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id
LEFT JOIN cut_sizes as c ON i.cut_id = c.cut_id
WHERE i.removed_date IS NULL AND s.type = '".$_POST["sheet_type"]."' AND v.name = '".$_POST["variant_name"]."'
GROUP BY width, height
";

$cutsizes_stock = [];
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		if($row['width'] != NULL && $row['height'] != NULL) {
			array_push($cutsizes_stock, [$row['width'], $row['height'], $row['In Stock']]);
		}
	}
}

$sql = "
SELECT DISTINCT cut_id, width, height, price
FROM cut_sizes c
LEFT JOIN sheet_type as s on c.type_id = s.type_id
WHERE s.type = '".$_POST["sheet_type"]."'
GROUP BY width, height
";

$cutsizes_id_price = [];
if ($result = $connection->query($sql)) {
	while ($row = $result->fetch_assoc() ){
		array_push($cutsizes_id_price, [$row['width'], $row['height'], $row['cut_id'], $row['price']]);
	}
}


echo json_encode([$cutsizes_stock, $cutsizes_id_price]);

$connection->close();
 ?>