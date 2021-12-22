<?php

require_once '../dbconnect.php';

session_start();

if (isset($_POST['action']) && $_POST['action'] == 'subtraction') {

    if ($_POST['current_qty'] > 1) {
        $item_array = array(
            'product_id' => $_POST['product_id'],
            'product_qty' => $_POST['current_qty'] - 1
        );
        $_SESSION['cart'][$_POST['element_id']] = $item_array;
        echo json_encode(["statusCode" => 200,
            "product_qty" => $item_array['product_qty']]);
    } else if ($_POST['current_qty'] == 1) {
        unset($_SESSION['cart'][$_POST['element_id']]);
        echo json_encode(["statusCode" => 201]);
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'increase') {

    if ($_POST['current_qty'] > 0) {
        $item_array = array(
            'product_id' => $_POST['product_id'],
            'product_qty' => $_POST['current_qty'] + 1
        );

        $_SESSION['cart'][$_POST['element_id']] = $item_array;
        echo json_encode(["statusCode" => 200,
            "product_qty" => $item_array['product_qty']]);
    }
}
