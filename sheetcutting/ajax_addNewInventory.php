<?php
include('ajax_connectToDatabase.php');

$amount = $_POST["amount"];

for($i = 0; $i < $amount; $i++) {
    $sql ="INSERT INTO sheet_inventory (variant_id, cut_id) VALUES (" . $_POST["variantid"] . ", " . $_POST["cutid"] . ");";

    if ($result = $connection->query($sql)) {
        echo "inserted";
    }
}

$connection->close();
 ?>