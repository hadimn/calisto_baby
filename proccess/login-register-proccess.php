<?php
// login-register.php

include 'classes/database.php';
include 'classes/customer.php';


// Database connection
$database = new Database();
$db = $database->getConnection();

// Customer object
$customer = new Customer($db);

// Registration handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    $errors = [];

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen((string) $phone_number) < 8 || strlen((string) $phone_number) > 8) {
        $errors[] = "Invalid phone number: \"it should be 8 digits only!\"";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.";
    }

    if (empty($errors)) {
        $customer->first_name = $first_name;
        $customer->last_name = $last_name;
        $customer->email = $email;
        $customer->phone_number = $phone_number;
        $customer->address = $address;
        $customer->password = password_hash($password, PASSWORD_DEFAULT);

        if ($customer->create()) {
            $registration_success = "Registration successful! You can now login.";
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}

// Login handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['login_email']);
    $password = $_POST['login_password'];

    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    }

    if (empty($errors)) {
        $customer->email = $email;

        if ($customer->findByEmail()) {
            if ($customer->validatePassword($password)) {
                session_start();
                $_SESSION['customer_id'] = $customer->customer_id;
                $_SESSION['customer_email'] = $customer->email;
                $_SESSION['logged_in'] = true;
                header("Location: index.php"); // Redirect to a logged-in page
                exit();
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "Email not found.";
        }
    }
}
?>