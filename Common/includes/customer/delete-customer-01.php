<?php
require_once '../dbconnect.php';

$customer_id = $_POST['customerid'];


$query = "DELETE FROM customers WHERE id=$customer_id";
$result = $conn->query($query);



if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201
    ]);
}


$conn->close();