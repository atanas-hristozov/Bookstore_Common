<?php
require_once '../dbconnect.php';



$customer_id = mysql_entities_fix_string($conn, $_POST['customer_id']);
$purchase_date = date('Y-m-d G:i:s');
$book_isbn =  $_POST['line_items'];
$total = mysql_entities_fix_string($conn, $_POST['total']);
$name = mysql_entities_fix_string($conn, $_POST['name']);
$email = mysql_entities_fix_string($conn, $_POST['email']);
$phone = mysql_entities_fix_string($conn, $_POST['phone']);
$address = mysql_entities_fix_string($conn, $_POST['address']);


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
$result = "";
$query = "INSERT INTO orders (customer_id, purchase_date, book_isbn, total, name, email, phone, address) VALUES" .
            "('$customer_id', '$purchase_date', '$book_isbn', '$total', '$name', '$email', '$phone', '$address')";
    $result = $conn->query($query);
    if ($result) {
        echo json_encode(["statusCode" => 200]);
    } else {
        echo json_encode([
            "statusCode" => 201
        ]);
    }
} else {
    echo json_encode(["statusCode" => 202]);
}
$conn->close();
?>