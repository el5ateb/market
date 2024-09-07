<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elkhateb Market | Edit Product</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom CSS */
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
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
    .form-input {
      margin-bottom: 1rem;
    }
    .form-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #555;
      font-size: 1.05rem;
    }
    .file-input {
      display: none;
    }
    .file-label {
      background-color: #007bff;
      padding: 0.5rem 1rem;
      color: #fff;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
      font-weight: bold;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .file-label:hover {
      background-color: #0056b3;
    }
    .submit-btn {
      width: 100%;
      background: linear-gradient(45deg, #6a11cb, #2575fc);
      color: #fff;
      padding: 0.75rem;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      font-weight: bold;
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .submit-btn:hover {
      background: linear-gradient(45deg, #2575fc, #6a11cb);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .view-products-link {
      display: block;
      margin-top: 1rem;
      text-align: center;
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    .view-products-link:hover {
      color: #0056b3;
    }
    .image-upload-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1.5rem;
    }
    .current-image {
      max-width: 150px;
      height: auto;
      margin-right: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    @media (max-width: 576px) {
      .form-container {
        padding: 1rem;
      }
      .current-image {
        max-width: 100px;
        margin-right: 10px;
      }
      .file-label {
        font-size: 0.9rem;
        padding: 0.5rem;
      }
    }
  </style>
</head>
<body>

<?php 
// Database connection
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$ID = $_GET['id'];
$query = "SELECT * FROM products WHERE id = " . mysqli_real_escape_string($con, $ID);
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result); 
} else {
  die("Product not found");
}

mysqli_close($con);
?>

  <div class="form-container">
    <form action="product_update.php" method="post" enctype="multipart/form-data">
      <h1>Edit Product</h1>

      <input type="hidden" name="id" value="<?php echo $product['id']; ?>" class="form-control form-input">
      <div class="mb-3">
        <label for="productName" class="form-label">Product Name</label>
        <input type="text" id="productName" name="name" value="<?php echo $product['name']; ?>" placeholder="Enter product name" required class="form-control form-input">
      </div>
      <div class="mb-3">
        <label for="productPrice" class="form-label">Product Price</label>
        <input type="text" id="productPrice" name="price" value="<?php echo $product['price']; ?>" placeholder="Enter product price" required class="form-control form-input">
      </div>
      <div class="mb-3">
        <label for="productDescription" class="form-label">Product Description</label>
        <textarea id="productDescription" name="description" placeholder="Enter product description" required class="form-control form-input" rows="4"><?php echo $product['description']; ?></textarea>
      </div>

      <div class="image-upload-container">
        <img id="currentImage" src="<?php echo $product['image']; ?>" alt="Current Product Image" class="current-image">
        <label for="file" class="file-label">Upload New Image</label>
        <input type="file" id="file" name="image" class="file-input">
      </div>

      <button type="submit" name="update" class="btn submit-btn">Update Product</button>
      <a href="admin.php" class="view-products-link">Show All Products</a>
    </form>
  </div>
</body>
</html>
