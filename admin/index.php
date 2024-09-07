<?php 
session_start();
$con = new mysqli("localhost", "root", "", "shop_db");
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elkhateb Market | Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Custom CSS for enhancing UI/UX */
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }
    .form-container h1 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #343a40;
    }
    .banner-img {
      display: block;
      margin: 0 auto 1.5rem;
      width: 100%;
      max-width: 100%;
      height: auto;
      border-radius: 8px;
    }
    .form-input {
      margin-bottom: 1rem;
    }
    .file-upload-section {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }
    .file-label {
      background-color: #ffc107;
      padding: 0.5rem;
      border-radius: 4px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      margin-right: 10px;
    }
    .file-text {
      color: #6c757d;
      font-size: 0.9rem;
      margin-right: 10px;
    }
    .file-input {
      display: none;
    }
    .submit-btn {
      width: 100%;
      background: linear-gradient(45deg, #ff7e5f, #feb47b);
      color: #fff;
      padding: 0.75rem;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .submit-btn:hover {
      background: linear-gradient(45deg, #feb47b, #ff7e5f);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    .view-products-link {
      display: block;
      margin-top: 1rem;
      text-align: center;
      color: #007bff;
      text-decoration: none;
      font-size: 1rem;
      font-weight: bold;
    }
    .view-products-link:hover {
      text-decoration: underline;
    }
  </style>
  <script>
    function validateForm(event) {
      const fileInput = document.getElementById('file');
      if (!fileInput.files.length) {
        alert('Please upload an image before submitting.');
        event.preventDefault(); 
      }
    }
  </script>
</head>
<body>
  <div class="form-container">
    <form action="insert.php" method="post" enctype="multipart/form-data" onsubmit="validateForm(event)">
      <h1>Add New Product</h1>
      <img src="banner.png" alt="banner" class="banner-img">
      <input type="text" name="name" placeholder="Product Name" required class="form-control form-input">
      <input type="text" name="price" placeholder="Product Price" required class="form-control form-input">
      <textarea name="description" placeholder="Product Description" required class="form-control form-input" rows="4"></textarea>
      <div class="file-upload-section">
        <span class="file-text">Product Image</span>
        <label for="file" class="file-label">Upload Image</label>
        <input type="file" id="file" name="image" class="file-input" accept="image/jpg, image/jpeg, image/png" required>
      </div>
      <button name="upload" class="btn submit-btn">Upload Product</button>
      <a href="admin.php" class="view-products-link">Show All Products</a>
    </form>
  </div>
</body>
</html>
