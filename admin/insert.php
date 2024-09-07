<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["upload"])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    
    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_location = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024;
        
        if (in_array($image_type, $allowed_types) && $image_size <= $max_size) {
            $new_image_name = md5(time() . $image_name) . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
            $upload_directory = 'images/';
            $image_path = $upload_directory . $new_image_name;
            
            if (move_uploaded_file($image_location, $image_path)) {
                $insert = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$image_path')";
                
                if (mysqli_query($con, $insert)) {
                    $message = 'Product uploaded and added to the database successfully!';
                } else {
                    $message = 'Failed to add product to the database: ' . mysqli_error($con);
                }
            } else {
                $message = 'Failed to upload the product image.';
            }
        } else {
            $message = 'Invalid file type or size. Please upload a valid image file.';
        }
    } else {
        $message = 'No image uploaded. Please upload an image before submitting.';
    }

    mysqli_close($con);

    // Redirect to popup page with message
    header("Location: popup.html?message=" . urlencode($message));
    exit();
}
