<?php
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {die("Connection failed: " . mysqli_connect_error());}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $delete_query = "DELETE FROM products WHERE id = '$id'";

    if (mysqli_query($con, $delete_query)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($con);