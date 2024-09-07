<?php 
session_start();
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {die("Connection failed: " . mysqli_connect_error());}


if (isset($_POST["submit"])) {
    // Retrieve and handle form data
    $name = $_POST["name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    // Create the SQL insert query
    $insert = "INSERT INTO cart (name, price, quantity) VALUES ('$name', '$price', '$quantity')";

    // Execute the query
    if (mysqli_query($con, $insert)) {
        // Redirect to cart.php on success
        header('Location: cart.php');
        exit();
    } else {
        // Output error if the query fails
        echo "Error: " . mysqli_error($con);
    }
}

// Close connection
mysqli_close($con);
