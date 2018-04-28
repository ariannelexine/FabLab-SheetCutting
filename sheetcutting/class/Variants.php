<?php
include('ajax_connectToDatabase.php');

class Variants {

    public static function insertColorVariants($type_id, $colorvar_json) {
        global $mysqli;
        
        // ---- Insert into the variants table all the new color variants decoded from the json string ---
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

            if($mysqli->query ("INSERT INTO variants (color_id, description, name, colorhex, type_id) VALUES (".$colorid.", ".$colordescription.", ".$colorname.", ".$colorhex.", ".$type_id.");")) {
                echo "Added " . $name , "\n";
            } else {
                return $mysqli->error;
            }
        }
    }

    public static function insertVariants($type_id, $var_json) {
        global $mysqli;
        
        // ---- Insert into the variants table all the new variants decoded from the json string ---
        // $var_json = $_POST["variants"];
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
            
            if($mysqli->query ("INSERT INTO variants (description, name, type_id) VALUES (".$description.", ".$name.", ".$type_id.");")) {
                echo "Added " . $name , "\n";
            } else {
                return $mysqli->error;
            }
        }
    }
}