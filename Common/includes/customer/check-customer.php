<?php
session_start();

if(!isset($_SESSION['login_user'])){
    header("location:./customer-login.php");
    die();
}

?>