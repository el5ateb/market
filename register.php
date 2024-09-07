<?php 
$con = mysqli_connect("localhost", "root", "", "shop_db");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($con, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    // Check if image folder exists, if not create it
    if (!file_exists('uploaded_img')) {
        mkdir('uploaded_img', 0777, true);
    }

    $select = mysqli_query($con, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select) > 0) {
        $message = 'User already exists!';
        $alert_type = 'danger';
    } elseif ($pass !== $cpass) {
        $message = 'Passwords do not match!';
        $alert_type = 'danger';
    } elseif (empty($image)) {
        $message = 'Image is required!';
        $alert_type = 'danger';
    } elseif ($image_size > 2000000) {
        $message = 'Image size is too large!';
        $alert_type = 'danger';
    } else {
        $insert = mysqli_query($con, "INSERT INTO `users`(user_name, email, user_password, user_image) VALUES('$name', '$email', '$pass', '$image')") or die('Query failed');
        if ($insert) {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $message = 'Registered successfully!';
                $alert_type = 'success';
                echo '<script>setTimeout(function(){ window.location.href = "login.php"; }, 2000);</script>';
            } else {
                $message = 'Image upload failed!';
                $alert_type = 'danger';
            }
        } else {
            $message = 'Registration failed!';
            $alert_type = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .form-container h3 {
            margin-bottom: 20px;
            color: #007bff;
            font-weight: 600;
            text-align: center;
        }
        .form-container .box {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
        .form-container .btn {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: none;
            background-color: #007bff;
            color: #ffffff;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .form-container .btn:hover {
            background-color: #0056b3;
        }
        .form-container p {
            text-align: center;
        }
        .form-container p a {
            color: #007bff;
            text-decoration: none;
        }
        .form-container p a:hover {
            text-decoration: underline;
        }
        .toast-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            width: 80%;
            max-width: 500px;
        }
        .toast {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .toast.show {
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="toast-container">
    <?php if (isset($message)): ?>
        <div class="toast <?php echo $alert_type === 'success' ? 'bg-success text-white' : 'bg-danger text-white'; ?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="me-auto"><?php echo $alert_type === 'success' ? 'Success' : 'Error'; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo $message; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Create a New Account</h3>
        <input type="text" name="name" required placeholder="Enter Username" class="box">
        <input type="email" name="email" required placeholder="Enter Email" class="box">
        <input type="password" name="password" required placeholder="Enter Password" class="box">
        <input type="password" name="cpassword" required placeholder="Confirm Password" class="box">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
        <input type="submit" name="submit" class="btn" value="Register">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        toastList.forEach(toast => toast.show());
    });
</script>
</body>
</html>
