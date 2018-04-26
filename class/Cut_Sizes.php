<?php

class Cut_Sizes {

    public static function getSheetSizes($type_id){
        global $mysqli;
        $sheet_sizes = array();
        
        if ($result = $mysqli->query("
            SELECT *
            FROM cut_sizes
            WHERE type_id = '$type_id'
        ")){
            while( $row = $result->fetch_assoc() ) {
                //array_push ($device_mats, array("m_id" => $row["m_id"], "price" => $row["price"], "m_name" => $row["m_name"], "unit" => $row["unit"]));
                array_push($sheet_sizes, array("cut_id" => $row["cut_id"], "width" => $row["width"], "height" => $row["height"]));
            }
            return $sheet_sizes;
        } else {
            return false;
        }
    }

    public static function insertCutSizes($type_id, $size_json) {
        global $mysqli;
        
        // ---- Insert into the cut_size table all the new sizes decoded from the json string ---
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
   
            if($mysqli->query ("INSERT INTO cut_sizes (width, height, price, type_id) VALUES (".$width.", ".$height.", ".$price.", ".$type_id.");")) {
                echo "Added " . $name , "\n";
            } else {
                return $mysqli->error;
            }
        }
    }
}