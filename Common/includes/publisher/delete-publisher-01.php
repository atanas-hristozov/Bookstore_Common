<?php
require_once '../dbconnect.php';

$publisher_id = $_POST['publisherid'];


$query = "DELETE FROM publishers WHERE id=$publisher_id";
$result = $conn->query($query);




if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201
    ]);
}


$conn->close();