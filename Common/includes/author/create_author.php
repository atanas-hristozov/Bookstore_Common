<?php
require_once '../dbconnect.php';


$name = mysql_entities_fix_string($conn, $_POST['name']);
$bio = mysql_entities_fix_string($conn, $_POST['bio']);
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


$query = "INSERT INTO authors (name, bio, created_at) VALUES" .
            "('$name', '$bio', '$date_created')";
    $result = $conn->query($query);

    if ($result) {
        echo json_encode(["statusCode" => 200]);
    } else {
        echo json_encode([
            "statusCode" => 201
        ]);
    }

$conn->close();