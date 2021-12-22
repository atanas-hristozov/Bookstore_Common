<?php

require_once '../dbconnect.php';

$name = mysql_entities_fix_string($conn, $_POST['name']);
$email = mysql_entities_fix_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone = mysql_entities_fix_string($conn, $_POST['phone']);
$address = mysql_entities_fix_string($conn, $_POST['address']);
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
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
$query = "SELECT * FROM customers WHERE name='$name' OR email='$email'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo json_encode(["statusCode" => 201]);
} else {
    $query = "INSERT INTO customers (name, password, phone, email, address, registrated) "
            . "VALUES ('$name', '$password','$phone', '$email', '$address', '$date_created')";
    $result = $conn->query($query);
    
    if ($result) {
        echo json_encode(["statusCode" => 200]);
    } else {
        echo json_encode(["statusCode" => 201]);
    }
}
} else {
    echo json_encode(["statusCode" => 202]);
}
$conn->close();
?>