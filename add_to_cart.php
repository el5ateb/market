<?php 
    // Database connection
    $con = mysqli_connect("localhost", "root", "", "shop_db");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $price = isset($_GET['price']) ? floatval($_GET['price']) : 0;    $stmt = $con->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <style>
            body {
                background-color: #f7f7f7;
                font-family: "Roboto", sans-serif;
            }
            h3 {
                color: #333;
                font-family: "Roboto", sans-serif;
                font-weight: bold;
                margin: 20px 0;
            }
            .container {
                max-width: 1200px;
                margin: auto;
            }
            .card {
                width: 16rem;
                margin: 15px;
                border: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                transition: transform 0.2s ease-in-out;
                background-color: #fff;
                border-radius: 10px;
            }
            .card:hover {
                transform: scale(1.03);
            }
            .card-img-top {
                height: 180px;
                object-fit: cover;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }
            .card-body {
                padding: 20px;
                text-align: center;
            }
            .card-title {
                font-size: 1.2rem;
                font-weight: bold;
                color: #333;
            }
            .card-text {
                font-size: 1.1rem;
                color: #666;
                margin-bottom: 10px;
            }
            .btn {
                padding: 10px;
                font-size: 1rem;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }
            .btn-info {
                background-color: #3498db;
                border: none;
                color: #fff;
            }
            .btn-info:hover {
                background-color: #2980b9;
            }
            .btn-primary {
                background-color: #3498db; /* Yellow background */
                border: none;
                color: #fff;
            }
            .btn-primary:hover {
                background-color: #3498db; /* Darker yellow on hover */
            }
            .row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            .form-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: auto;
                text-align: center;
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
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Do you want to buy this product?</h2>
            <form action="insert_cart.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($data['name']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="price" id="price" value="<?php echo htmlspecialchars($data['price']); ?>" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1">
                </div>
                <input type="hidden" name="image" value="<?php echo htmlspecialchars($data['image']); ?>">
                <button type="submit" name="submit" class="btn btn-primary">Add to Cart</button>
                <br><br>                
                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka+hoIf5tWiwG5jEYpM5Vf9F0AGmGUsGJ6L4Gh3oPHUsFE7r1I5ER6EAxGcFEFjx" crossorigin="anonymous"></script>
</body>
</html>
