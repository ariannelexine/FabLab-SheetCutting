<?php
include('ajax_connectToDatabase.php');

class Sheet_Type {
    private $type_id;
    private $type;

    public function __construct($type_id) {
        global $mysqli;
        $this->type_id = $type_id;
        
        if ($result = $mysqli->query("
            SELECT *
            FROM `sheet_type`
            WHERE `type_id` = '$type_id'
            LIMIT 1;
        ")){
            $row = $result->fetch_assoc();
            $this->setType($row['type']);
            $result->close();
        } else
            throw new Exception("Invalid Type ID");
    }

    public function getTypeID() {
        return $this->type_id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public static function insertSheetType($type) {
        global $mysqli;

        if($mysqli->query ("
            INSERT INTO sheet_type (`type`) VALUES ('".$type."');")) {
            return $mysqli->insert_id;
        } else {
            return $mysqli->error;
        }
    }
}