<?php 
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elkhateb Market | All Products</title>
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
      width: 12rem;
      margin: 10px;
      border: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease-in-out;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card-img-top {
      height: 150px;
      object-fit: cover;
    }
    .card-body {
      padding: 10px;
    }
    .card-title {
      font-size: 1rem;
      font-weight: bold;
      color: #333;
    }
    .card-text {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 5px;
    }
    .btn {
      width: 100%;
      padding: 0.5rem;
      font-size: 0.85rem;
      border-radius: 0.375rem;
    }
    .btn-warning {
      background-color: #ffc107;
      border-color: #ffc107;
      transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-warning:hover {
      background-color: #e0a800;
      border-color: #d39e00;
    }
    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
      transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
    }
    @media (max-width: 768px) {
      .card {
        width: 100%;
        margin-bottom: 15px;
      }
    }
  </style>
</head>
<body>
  <center><h3>All Products | Admin Portal</h3></center>

  <div class="container">
    <div class="row">
      <?php 
      $sql = "SELECT * FROM products";
      $result = mysqli_query($con, $sql);
      if (!$result) {
          die("Query failed: " . mysqli_error($con));
      }

      while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <div class="card">
            <img class="card-img-top" src="'.htmlspecialchars($row['image']).'" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title">'.htmlspecialchars($row['name']).'</h5>
              <p class="card-text">$'.htmlspecialchars($row['price']).'</p>
              <a href="product_edit.php?id='.urlencode($row['id']).'" class="btn btn-warning mb-2">Edit</a>
              <a href="product_delete.php?id='.urlencode($row['id']).'" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
            </div>
          </div>
        ';
      }

      mysqli_close($con);
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
