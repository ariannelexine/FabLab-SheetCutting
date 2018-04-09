<?php
$server = 'localhost';
$user = 'Fablabian';
$password = 'sbVaBEd3eW9dxmdb';
$database = 'fabapp-v0.9';
$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$sql = "INSERT INTO sheet_type (type) VALUES ('".$_POST["sheet_type"]."');";

// If inserting a new sheet type into the database was successful
if ($result = $connection->query($sql)) {
    $sql1 = "SELECT * FROM sheet_type WHERE type = '".$_POST["sheet_type"]."';";
    if ($result = $connection->query($sql1)) {
        // Get the type_id of the newly created sheet type to use for the new variants and cut sizes
        $type_id;
        while ($row = $result->fetch_assoc() ){
           $type_id = $row['type_id'];
        }

        // ---- Insert into the variants table all the new variants decoded from the json string ---
        $var_json = $_POST["variants"];
        $var_array = json_decode($var_json);
        
        // Iterate through each variant row
        for($i = 0; $i < count($var_array); $i++) {
            $id = "'".$var_array[$i]->id."'";
            $description = "'".$var_array[$i]->description."'";
            $name = "'".$var_array[$i]->name."'";
            $colorhex = "'".$var_array[$i]->colorhex."'";

            // Account for empty text boxes by inserting value as NULL in SQL 
            if($var_array[$i]->description == '') {
                $description = "NULL";
            }
            if($var_array[$i]->name == '') {
                $name = "NULL";
            }

            if($var_array[$i]->colorhex == '') {
                $colorhex = "NULL";
            }

            $variantsql = "INSERT INTO variants VALUES (".$id.", ".$description.", ".$name.", ".$colorhex.", ".$type_id.");";

            if ($result = $connection->query($variantsql)) {
                echo "successfully added.";
            }
        }

        // ---- Insert into the cut_size table all the new sizes decoded from the json string ---
        $size_json = $_POST["sizes"];
        $size_array = json_decode($size_json);
        
        // Iterate through each variant row
        for($i = 0; $i < count($size_array); $i++) {
            $width = $size_array[$i]->width;
            $height = $size_array[$i]->height;
            $price = $size_array[$i]->price;

            // Account for empty text boxes by inserting value as NULL in SQL 
            if($size_array[$i]->price == '') {
                $price = "NULL";
            }

            $sizesql = "INSERT INTO cut_sizes (width, height, price, type_id) VALUES (".$width.", ".$height.", ".$price.", ".$type_id.");";

            if ($result = $connection->query($sizesql)) {
                echo "successfully added.";
            }
        }
    }
}

$connection->close();
 ?>