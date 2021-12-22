<?php

session_start();
/*
if(session_destroy()){
    echo json_encode(['statusCode' => 200]);
} else {
    echo json_ecnode(['statusCode' => 201]);
}
*/
if(isset($_SESSION['login_user'])){
    unset($_SESSION['login_user']);
    echo json_encode(['statusCode' => 200]);
} else {
    echo json_ecnode(['statusCode' => 201]);
}

/*
if(isset($_GET['remove_cart'])){
    unset($_SESSION['login_user']);
}*/
?>