<?php

require_once '../dbconnect.php';

$username = mysql_entities_fix_string($conn, $_POST['username']);
$email = mysql_entities_fix_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = 'user';
$date_created = date('Y-m-G G:i:s');

function mysql_entities_fix_string($conn, $string) {
    return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string) {
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $string = stripcslashes($string);
    }
    return $conn->real_escape_string($string);
}

$query = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo json_encode(["statusCode" => 201]);
} else {
    $query = "INSERT INTO users (username, email, password, role, registrated) "
            . "VALUES ('$username', '$email', '$password', '$role', '$date_created')";
    $result = $conn->query($query);
    
    if ($result) {
        echo json_encode(["statusCode" => 200]);
    } else {
        echo json_encode(["statusCode" => 201]);
    }
}

$conn->close();
?>