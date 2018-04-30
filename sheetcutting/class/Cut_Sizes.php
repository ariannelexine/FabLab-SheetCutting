<?php
include('ajax_connectToDatabase.php');

class Cut_Sizes {

    public static function addChildren($childrenArray) {
        global $mysqli;
    //    echo "<script>console.log(" . json_encode($childrenArray) . ");</script>";
        foreach($childrenArray as $key => $cutsize) {
            // echo "<script>console.log(" . json_encode($childrenArray) . ");</script>";
            if($cutsize['parent'] != 'NULL') {
                if($cutsize['child1'] != 'NULL') {
                    echo "<script>console.log('" . $cutsize['parent'] . " " . $cutsize['child1'] . " " . $cutsize['amount1'] ."');</script>";
                    $mysqli->query ("INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES  (".$cutsize['parent'].", ".$cutsize['child1'].", ".$cutsize['amount1'].");");
                } 
                if($cutsize['child2'] != 'NULL') {
                    echo "<script>console.log('" . $cutsize['parent'] . " " . $cutsize['child2'] . " " . $cutsize['amount2'] ."');</script>";
                    $mysqli->query ("INSERT INTO cutsize_children (parent_id, child_id, amount) VALUES  (".$cutsize['parent'].", ".$cutsize['child2'].", ".$cutsize['amount2'].");");
                }
            }
        }
    }

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
                array_push($sheet_sizes, array("cut_id" => $row["cut_id"], "width" => $row["width"], "height" => $row["height"], "price" => $row["price"]));
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