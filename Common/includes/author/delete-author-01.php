<?php
require_once '../dbconnect.php';

$author_id = $_POST['authorid'];


$query = "DELETE FROM authors WHERE id=$author_id";
$result = $conn->query($query);




if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201
    ]);
}


$conn->close();