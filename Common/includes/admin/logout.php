<?php
session_start();
if(session_destroy()){
    echo json_encode(['statusCode' => 200]);
} else {
    echo json_ecnode(['statusCode' => 201]);
}
?>