 <?php
include('ajax_connectToDatabase.php');

$connection = mysqli_connect($server, $user, $password, $database);
if ($connection->connect_error) {
	exit('Connection failed: ' . $connection->connect_error);
}

$successfulAdds = 0;
$amount = $_POST["amount"];

for($i = 0; $i < $amount; $i++) {
    $sql_insert ="INSERT INTO sheet_inventory (variant_id, cut_id) VALUES (" . $_POST["variantid"] . ", " . $_POST["cutid"] . ");";

    if ($result = $connection->query($sql_insert)) {
        $successfulAdds++;
    }
}

echo $successfulAdds;

$connection->close();
 ?>