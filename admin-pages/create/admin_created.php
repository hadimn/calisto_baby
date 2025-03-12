<?php
session_start();

// Ensure the admin account creation message is available
if (!isset($_SESSION['admin_created'])) {
    header("Location: ../index.php"); // Redirect if accessed directly
    exit();
}

$email = $_SESSION['admin_email'];
$password = $_SESSION['admin_password'];

// Clear the session variables for security
unset($_SESSION['admin_created']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_password']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account Created</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Account Created</h2>
        <div class="alert alert-success">
            <strong>Success!</strong> Your admin account has been created.
        </div>
        <div class="alert alert-info">
            <strong>Email:</strong> <?= $email ?><br>
            <strong>Password:</strong> <?= $password ?><br>
            Please save this information. You will not be able to view it again.
        </div>
        <a href="../loginpage.php" class="btn btn-primary w-100">Go to Login</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
