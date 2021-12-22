<?php
require_once '../dbconnect.php';

$category_id = $_POST['categoryid'];


$query = "DELETE FROM categories WHERE id=$category_id";
$result = $conn->query($query);




if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201
    ]);
}


$conn->close();