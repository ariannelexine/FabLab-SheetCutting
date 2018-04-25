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

        // ---- Insert into the variants table all the new color variants decoded from the json string ---
        $colorvar_json = $_POST["colorvariants"];
        $colorvar_array = json_decode($colorvar_json);
        
        // Iterate through each variant row
        for($i = 0; $i < count($colorvar_array); $i++) {
            $colorid = "'".$colorvar_array[$i]->colorid."'";
            $colordescription = "'".$colorvar_array[$i]->colordescription."'";
            $colorname = "'".$colorvar_array[$i]->colorname."'";
            $colorhex = "'".$colorvar_array[$i]->colorhex."'";

            // Account for empty text boxes by inserting value as NULL in SQL 
            if($colorvar_array[$i]->colordescription == '') {
                $colordescription = "NULL";
            }
            if($colorvar_array[$i]->colorname == '') {
                $colorname = "NULL";
            }

            if($colorvar_array[$i]->colorhex == '') {
                $colorhex = "NULL";
            }

            $colorvariantsql = "INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES (".$colorid.", ".$colordescription.", ".$colorname.", ".$colorhex.", ".$type_id.");";

            if ($result = $connection->query($colorvariantsql)) {
                echo "Added " . $colorname , "\n";
            }
        }

        // ---- Insert into the variants table all the new variants decoded from the json string ---
        $var_json = $_POST["variants"];
        $var_array = json_decode($var_json);
        
        // Iterate through each variant row
        for($i = 0; $i < count($var_array); $i++) {
            $description = "'".$var_array[$i]->description."'";
            $name = "'".$var_array[$i]->name."'";

            // Account for empty text boxes by inserting value as NULL in SQL 
            if($var_array[$i]->description == '') {
                $description = "NULL";
            }
            if($var_array[$i]->name == '') {
                $name = "NULL";
            }

            $variantsql = "INSERT INTO variants (description, name, type_id) VALUES (".$description.", ".$name.", ".$type_id.");";

            if ($result = $connection->query($variantsql)) {
                echo "Added " . $name , "\n";
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
                echo "Added " . $width . "x" . $height . "\n";
            }
        }
    }
    echo "Successfully added " . $_POST["sheet_type"];
}

$connection->close();
 ?>