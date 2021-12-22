<?php
require_once '../dbconnect.php';


$isbn = mysql_entities_fix_string($conn, $_POST['isbn']);
$title = mysql_entities_fix_string($conn, $_POST['title']);
$author = mysql_entities_fix_string($conn, $_POST['author']);
$category = mysql_entities_fix_string($conn, $_POST['category']);
$year = mysql_entities_fix_string($conn, $_POST['year']);
$description = mysql_entities_fix_string($conn, $_POST['description']);
$lang = mysql_entities_fix_string($conn, $_POST['lang']);
$price = mysql_entities_fix_string($conn, $_POST['price']);
$pages = mysql_entities_fix_string($conn, $_POST['pages']);
$publisher = mysql_entities_fix_string($conn, $_POST['publisher']);
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

//kak da go vzema tova id
$book_id = $_POST['bookid'];
//var_dump($_POST);

if (($image == "" && $flag == "") || ($image != "" && $flag == "" )) {
    $query = "UPDATE books SET isbn='$isbn', title='$title', author_id='$author', category_id='$category', image='$image', year='$year', description='$description', lang='$lang'," .
    " price='$price', pages='$pages', publisher_id='$publisher', created_at='$date_created' WHERE id = $book_id";
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