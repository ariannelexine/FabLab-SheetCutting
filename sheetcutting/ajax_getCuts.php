<?php
$server = 'localhost';
$user = 'Fablabian';
$password = 'sbVaBEd3eW9dxmdb';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}
include('class_sheet.php');
session_start();

$cuts = []; // new empty array
$starter_sheet = new Sheet($_POST["sheet_type"], $_POST["name"], $_POST["variant_id"], $_POST["cut_id"], $_POST["count"], $_POST["width"], $_POST["height"], $_POST["price"]);

find_parents($starter_sheet, $connection);

//print_r($starter_sheet->parents);

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
					$sheet_parent = new Sheet($row2['type'], $row2['name'], $row2['variant_id'], $row2['cut_id'], $row2['In Stock'], $row2['width'], $row2['height'], $row2['price']);
					find_parents($sheet_parent, $connection);
					array_push($sheet->parents, $sheet_parent);
				}
			}
		}
	}
}

// Recursively find the cuts needed for the sheet.
function get_cuts(&$sheet, &$list) {
	array_push($list, $sheet); // add sheet to list
	if($sheet->amount < 1) {
		if($sheet->parents != NULL) {
			$count_parents = count($sheet->parents);
			if($count_parents > 0) {
				
				/*
				* Check for empty lists, if one of the lists is empty, return the non empty one. If both are empty, return path1*
				* Check to see if one of the lists is longer than the other, and return the shorter list*
				* If both lists are the same size, return the list whose last item has the greater quantity*
				* If both lists have the same quantity in the last item, return the 1st list*
				*/
				
				$list1 = [];
				$path1 = get_cuts($sheet->parents[0], $list1);
				if($count_parents == 1) {
					$list = array_merge($list, $list1);
					return $path1;
				} else {
					$list2 = [];
					$path2 = get_cuts($sheet->parents[1], $list2);
					$distance1 = count($list1);
					$distance2 = count($list2);
					if($distance1 == $distance2) {
						if($path1->amount == $path2->amount) {
							$list = array_merge($list, $list1);
							return $path1;
						} else if($path2->amount > $path1->amount) {
							$list = array_merge($list, $list2);
							return $path2;
						} else {
							$list = array_merge($list, $list1);
							return $path1;
						}
					} else if($distance1 < $distance2){
						$list = array_merge($list, $list1);
						return $path1;
					} else if($distance1 > $distance2){
						$list = array_merge($list, $list2);
						return $path2;
					} else {
						$list = array_merge($list, $list1);
						return $path1;
					}
				}
			} else {
				return $sheet;
			}
		} else {
			return $sheet;
		}
	} else {
		return $sheet;
	}
	return $sheet;
}

$list = [];
$last_element = get_cuts($starter_sheet, $list);

$cut_into = [];
for($i = 0; $i < count($list); $i++) {
	$sql_cuts = "SELECT * FROM `cutsize_children` WHERE `parent_id`='".$list[$i]->cut_id."'";
	$cut_into_elements = [];
	if ($result = $connection->query($sql_cuts)) {
		while ($row = $result->fetch_assoc()) {
			array_push($cut_into_elements, $row["child_id"].','.$row["amount"]);
		}
	}
	array_push($cut_into, $cut_into_elements);
}

$send_data = [$list, $cut_into];

// Save list array to session to be used in another file.
$_SESSION['Cuts'] = serialize($send_data);

if($last_element->amount > 0) {
	// Send back list as JSON data to the client for display.
	echo json_encode($send_data);
} else { 
	// No sheets could be found, alert worker that there is no stock.
	echo 'Out of stock!';
}

$connection->close();
 ?>