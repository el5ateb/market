<?php
// Start the session
session_start();
$host = 'localhost';
$dbname = 'shop_db';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch product details from the database
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .product-img {
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #ddd; /* Add a border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
        }
        .product-img:hover {
            transform: scale(1.05); /* Slightly enlarge the image on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Increase shadow on hover */
        }
        .product-details {
            margin-top: 20px;
        }
        .product-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 24px;
            color: #e91e63;
            margin-bottom: 20px;
        }
        .product-description {
            font-size: 16px;
            line-height: 1.5;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .add-to-cart-btn,
        .back-to-shop-btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px; /* Add space between buttons */
        }
        .add-to-cart-btn {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
        }
        .add-to-cart-btn:hover {
            background-color: #45a049;
        }
        .back-to-shop-btn {
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }
        .back-to-shop-btn:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            color: #4CAF50;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Elkhateb Market</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Products</a>
                    </li>
                </ul>
                <a href="cart.php" class="btn btn-primary">My Cart</a>
            </div>
        </div>
    </nav>
  
    <div class="container">
        <div class="product-details row">
            <div class="col-md-6">
                <img class="product-img img-fluid" src="admin/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <div class="d-flex">
                    <a href="index.php" class="btn back-to-shop-btn">Back to Shop</a>
                  <a href="add_to_cart.php?id=<?php echo urlencode($product['id']); ?>&name=<?php echo urlencode($product['name']); ?>&price=<?php echo urlencode($product['price']); ?>" class="btn add-to-cart-btn">Add to Cart</a>
                </div>
            </div>
        </div>
        <div id="message" class="message"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function addToCart(productId) {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure it: POST-request to "add_to_cart.php"
            xhr.open("POST", "add_to_cart.php", true);

            // Set up the request headers
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Send the request with the product ID
            xhr.send("product_id=" + productId);

            // Listen for the request response
            xhr.onload = function() {
                if (xhr.status == 200) {
                    document.getElementById('message').textContent = 'Product added to cart!';
                } else {
                    document.getElementById('message').textContent = 'Failed to add product to cart.';
                }
            };
        }
    </script>

</body>
</html>
