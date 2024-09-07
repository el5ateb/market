<?php 
session_start();
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elkhateb Market | Shop</title>
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
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card-img-top {
      height: 180px;
      object-fit: cover;
    }
    .card-body {
      padding: 10px;
      text-align: center;
    }
    .card-title {
      font-size: 1.1rem;
      font-weight: bold;
      color: #333;
    }
    .card-text {
      font-size: 1rem;
      color: #666;
      margin-bottom: 10px;
    }
    .price {
      font-size: 1.2rem;
      color: #e91e63;
      margin-bottom: 10px;
    }
    .btn {
      width: 100%;
      padding: 10px;
      font-size: 0.9rem;
    }
    .btn-info {
      background-color: #3498db;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-info:hover {
      background-color: #2980b9;
    }
    .btn-primary {
      background-color: #2ecc71;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #27ae60;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
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
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Products</a>
          </li>
        </ul>
        <a href="cart.php" class="btn btn-primary">My Cart</a>
      </div>
    </div>
  </nav>

  <center><h3>All Products</h3></center>

  <div class="container">
    <div class="row">
      <?php 
      // Query to fetch products
      $sql = "SELECT * FROM products";
      $result = mysqli_query($con, $sql);
      if (!$result) {
          die("Query failed: " . mysqli_error($con));
      }

      // Display products
      while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <div class="card">
            <img class="card-img-top" src="admin/'.htmlspecialchars($row['image']).'" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title">'.htmlspecialchars($row['name']).'</h5>
              <p class="price">$'.number_format($row['price'], 2).'</p>
              <p class="card-text"></p>              
              <a href="product_details.php?id='.urlencode($row['id']).'" class="btn btn-info">View Details</a>
              <a href="add_to_cart.php?id='.urlencode($row['id']).'" class="btn btn-primary">Add to Cart</a>
            </div>
          </div>
        ';
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka+hoIf5tWiwG5jEYpM5Vf9F0AGmGUsGJ6L4Gh3oPHUsFE7r1I5ER6EAxGcFEFjx" crossorigin="anonymous"></script>
</body>
</html>
