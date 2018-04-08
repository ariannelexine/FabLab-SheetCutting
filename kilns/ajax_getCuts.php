<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}
include('class_sheet.php');
session_start();

$cuts = []; // new empty array
$starter_sheet = new Sheet($_POST["sheet_type"], $_POST["name"], $_POST["variant_id"], $_POST["count"], $_POST["width"], $_POST["height"], $_POST["price"]);
//print_r($starter_sheet);
find_parents($starter_sheet, $connection);
print_r($starter_sheet->parents);

function find_parents(&$sheet, $connection) {
	$sql = 'SELECT cut_id FROM cut_sizes WHERE width='.$sheet->width.' AND height = '.$sheet->height;
	if ($result = $connection->query($sql)) {
		while ($row = $result->fetch_assoc()) {
			$sql2 = "SELECT DISTINCT type, price, v.variant_id, name, c.cut_id, width, height, count(obj_id) as 'In Stock'
					FROM sheet_type s
					LEFT JOIN cut_sizes as c ON s.type_id = c.type_id
					LEFT JOIN variants as v ON s.type_id = v.type_id
					LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id AND i.cut_id = c.cut_id
					WHERE i.removed_date IS NULL AND v.variant_id = '" . $sheet->id . "' AND c.cut_id IN 
					(SELECT parent_id FROM cutsize_children WHERE child_id = " . $row['cut_id'] . ")
					GROUP BY name, width, height";
			if ($result2 = $connection->query($sql2)) {
				while ($row2 = $result2->fetch_assoc()){
					$sheet_parent = new Sheet($row2['type'], $row2['name'], $row2['variant_id'], $row2['In Stock'], $row2['width'], $row2['height'], $row2['price']);
					find_parents($sheet_parent, $connection);
					array_push($sheet->parents, $sheet_parent);
				}
			}
		}
	}
}
/*
function get_cuts($sheet, &$list) {
	if($starter_sheet->amount < 1) {
		if($starter_sheet->parents != NULL) {
			$count_parents = count($starter_sheet->parents);
			if($count_parents > 0) {
				$path = get_cuts($starter_sheet->parents[0], $list);
				if($count_parents == 1) {
					return $path;
				} else {
					$path2 = get_cuts($starter_sheet->parents[1], $list);
				}
			}
		}
	} else {
		array_push($list, $starter_sheet);
	}
	return $list;
}


$_SESSION['Cuts'] = serialize(get_cuts($starter_sheet, $cuts));
*/
$connection->close();
 ?>