<?php 
session_start();
$con = new mysqli("localhost", "root", "", "shop_db");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elkhateb Market | Cart</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background-color: #f4f4f4;
      font-family: 'Roboto', sans-serif;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    h3 {
      color: #333;
      font-weight: 600;
      margin: 30px 0;
      text-align: center;
    }
    .table {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
      padding: 15px;
      text-align: center;
    }
    .table th {
      background-color: #f8f9fa;
      color: #333;
      font-weight: 600;
    }
    .table td {
      border-bottom: 1px solid #e9ecef;
    }
    .table img {
      max-width: 100px;
      height: auto;
      border-radius: 4px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 0.9rem;
      border-radius: 4px;
      transition: background-color 0.3s ease, transform 0.2s ease;
      text-align: center;
      text-decoration: none;
      font-weight: 500;
    }
    .btn-info {
      background-color: #007bff;
      color: #fff;
    }
    .btn-info:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }
    .btn-primary {
      background-color: #ffc107;
      color: #333;
    }
    .btn-primary:hover {
      background-color: #e0a800;
      transform: scale(1.05);
    }
    .btn-danger {
      background-color: #dc3545;
      color: #fff;
    }
    .btn-danger:hover {
      background-color: #c82333;
      transform: scale(1.05);
    }
    .total-row {
      background-color: #f8f9fa;
      font-weight: 600;
      border-top: 2px solid #e9ecef;
    }
    .shipping-box {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
    }
    .btn-container {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }
    .btn-container .btn {
      flex: 1;
    }
    @media (max-width: 768px) {
      .btn-container {
        flex-direction: column;
      }
      .btn-container .btn {
        margin-bottom: 10px;
      }
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
    <main>
      <h3>Your Cart</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Product Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Product Price</th>
            <th scope="col">Total Price</th>
            <th scope="col">Delete Product</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $total_cost = 0;
          $query = "
            SELECT c.name, c.price, c.image, SUM(c.quantity) as total_quantity
            FROM cart c
            GROUP BY c.name, c.price, c.image
            ORDER BY c.name ASC
          ";
          $result = $con->query($query);

          if ($result) {
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      $item_total = floatval($row['price']) * intval($row['total_quantity']);
                      $total_cost += $item_total;
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['total_quantity']) . '</td>';
                      echo '<td>$' . htmlspecialchars($row['price']) . '</td>';
                      echo '<td>$' . number_format($item_total, 2) . '</td>';
                      echo '<td><a href="delete_cart.php?name=' . urlencode($row['name']) . '" class="btn btn-danger">Delete</a></td>';
                      echo '</tr>';
                  }
              } else {
                  echo '<tr><td colspan="6">No items found.</td></tr>';
              }
              $result->free();
          } else {
              echo '<tr><td colspan="6">Error: ' . $con->error . '</td></tr>';
          }
          ?>
          <tr class="total-row">
            <td colspan="4"><strong>Total Cost</strong></td>
            <td colspan="2">$<?php echo number_format($total_cost, 2); ?></td>
          </tr>
        </tbody>
      </table>
      <div class="shipping-box">
        <h3>Shipping Information</h3>
        <form action="place_order.php" method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="state" class="form-label">State</label>
              <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="col-md-3 mb-3">
              <label for="zip" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zip" name="zip" required>
            </div>
          </div>
          <div class="btn-container">
            <a href="index.php" class="btn btn-info">Continue Shopping</a>
            <button type="submit" class="btn btn-primary">Place Order</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
