<?php
require_once '../dbconnect.php';

$book_id = $_POST['bookid'];


$query = "DELETE FROM books WHERE id=$book_id";
$result = $conn->query($query);




if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201
    ]);
}


$conn->close();