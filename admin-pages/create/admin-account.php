<?php
// Start session to store session data
session_start();

// Include the necessary files (database connection and Admin class)
require_once "../../classes/database.php";
require_once "../../classes/admin.php"; // Ensure admin.php is included

// Database connection
$database = new Database();
$db = $database->getConnection();

// Check if the admin account already exists
$query = "SELECT * FROM admin LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$admin_exists = $stmt->fetch(PDO::FETCH_ASSOC);

// If the admin account exists, redirect and prevent further access
if ($admin_exists) {
    header("Location: ../index.php"); // Redirect to home or login page
    exit();
}

// If the account does not exist, create the admin account
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate a random email and password for the first-time admin account
    $email = "admin" . rand(1000, 9999) . "@calisto.com"; // Random admin email
    $password = bin2hex(random_bytes(8)); // Generate a random 8-byte password

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the admin account into the database
    try {
        $query = "INSERT INTO admin (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)";
        $stmt = $db->prepare($query);
        // Bind the email and hashed password as values
        $stmt->bindValue(':email', $email); 
        $stmt->bindValue(':password', $hashed_password); 
        $stmt->bindValue(':first_name', 'Admin'); 
        $stmt->bindValue(':last_name', 'User'); 
        $stmt->execute();

        // Set session variable to show account creation success message
        $_SESSION['admin_created'] = true;
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_password'] = $password;

        // Redirect to success page (or home page)
        header("Location: admin_created.php");
        exit();

    } catch (PDOException $e) {
        // Log database errors
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred while creating the admin account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Create Admin Account</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <div class="alert alert-info">
            <strong>Important:</strong> This is the only time you will be able to create an admin account. After creation, you will be redirected to the dashboard.
        </div>

        <form method="POST">
            <button type="submit" class="btn btn-primary w-100">Create Admin Account</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
