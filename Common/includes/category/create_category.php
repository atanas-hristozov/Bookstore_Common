<?php
require_once '../dbconnect.php';



$title = mysql_entities_fix_string($conn, $_POST['title']);
$description = mysql_entities_fix_string($conn, $_POST['description']);
$date_created = date('Y-m-d G:i:s');

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $string = stripcslashes($string);
    }
    return $conn->real_escape_string($string);
}

$flag = "";
$image = "";
if (!empty($_FILES['cover']['name'])) {
    $filename = $_FILES['cover']['name'];
    $destination = '../../uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    $file = $_FILES['cover']['tmp_name'];
    $size = $_FILES['cover']['size'];

    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'PNG'])) {
//        echo "You file extension must be .jpg, .jpeg or .png";
        $flag = 1;
    } elseif ($size > 1000000) { // до 1Megabyte
//        echo "File too large!";
        $flag = 2;
    } else {
        if (move_uploaded_file($file, $destination)) {
            $image = $_FILES['cover']['name'];
        } else {
//            echo "Failed to upload file.";
            $flag = 3;
        }
    }
}

$result = "";

if (($image == "" && $flag == "") || ($image != "" && $flag == "" )) {
    $query = "INSERT INTO categories ( title, image, description, created_at) VALUES" .
            "('$title', '$image', '$description', '$date_created')";
    $result = $conn->query($query);
}


if ($result) {
    echo json_encode(["statusCode" => 200]);
} else {
    echo json_encode([
        "statusCode" => 201,
        "flag" => $flag
    ]);
}


$conn->close();