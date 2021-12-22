<?php
require_once '../dbconnect.php';
session_start();
$name = mysql_entities_fix_string($conn, $_POST['name']);
$password = mysql_entities_fix_string($conn, $_POST['password']);

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $string = stripcslashes($string);
    }
    return $conn->real_escape_string($string);
}

$query = "SELECT password, id FROM customers WHERE name = '$name'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $h_pass = $row['password'];

    if (password_verify($password, $h_pass)) {
        $_SESSION['login_user'] = $row['id'];
        echo json_encode(["statusCode" => 200]);
    } else {
        echo json_encode(["statusCode" => 201]);
    }
} else {
    echo json_encode(["statusCode" => 202]);
}