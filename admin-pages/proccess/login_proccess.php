<?php

session_start();

// Set the include path for required files
require_once "../../classes/database.php";
require_once "../../classes/admin.php"; // Ensure admin.php is included
// Initialize an array for errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Sanitize and validate password
    $password = $_POST['password'];
    if (empty($password)) {
        $errors[] = "Password cannot be empty.";
    }

    // If there are no input validation errors, proceed with the database query
    if (empty($errors)) {
        $database = new Database();
        $db = $database->getConnection();
        $admin = new Admin($db);

        try {
            // Query the database for the admin with the provided email
            $query = "SELECT admin_id, first_name, last_name, email, password FROM admin WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the email exists
            if ($admin_data) {
                // Verify the password
                if (password_verify($password, $admin_data['password'])) {
                    // Successful login, set session variables
                    $_SESSION['admin_id'] = $admin_data['admin_id'];
                    $_SESSION['admin_name'] = $admin_data['first_name'] . ' ' . $admin_data['last_name'];
                    $_SESSION['logged_in'] = true;

                    // Redirect to the admin dashboard
                    header("Location: ../index.php");
                    exit();
                } else {
                    // Incorrect password, log the failed attempt
                    error_log("Failed login attempt for email: " . $email);
                    $errors[] = "Incorrect password.";
                }
            } else {
                // Email does not exist, log the failed attempt
                error_log("Failed login attempt for non-existent email: " . $email);
                $errors[] = "Email does not exist.";
            }

        } catch (PDOException $e) {
            // Log database errors
            error_log("Database error: " . $e->getMessage());
            $errors[] = "A database error occurred. Please try again later.";
        } catch (Exception $e) {
            // Log general errors
            error_log("General error: " . $e->getMessage());
            $errors[] = "An unexpected error occurred.";
        }
    }

    // If there are errors, store them in the session and redirect back to the login page
    $_SESSION['form_errors'] = $errors;
    header("Location: ../loginpage.php");
    exit();
} else {
    // If the page is accessed directly, redirect to login page
    header("Location: ../loginpage.php");
    exit();
}
?>
