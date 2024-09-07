<?php 
session_start();
$con = new mysqli("localhost", "root", "", "shop_db");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get the product name from the query string
$name = $con->real_escape_string($_GET['name']);

// Check if the name is valid
if (!empty($name)) {
    // Execute the query to delete all instances of the product by name
    $stmt = $con->prepare("DELETE FROM cart WHERE name = ?");
    $stmt->bind_param("s", $name);
    
    if ($stmt->execute()) {
        // Redirect to the cart page after deletion
        header('Location: cart.php');
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid product name.";
}

$con->close();

