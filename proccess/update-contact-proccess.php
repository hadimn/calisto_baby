<?php
require_once '../classes/database.php';
require_once '../classes/customer.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['customer_id'])) {
        $_SESSION['error_message'] = "User not logged in";
        header("Location: ../my-account.php");
        exit;
    }

    // Get input values
    $customer_id = $_SESSION['customer_id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : null;
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $_SESSION['error_message'] = "First name, last name, and email are required.";
        header("Location: ../my-account.php");
        exit;
    }

    // Validate password change (if provided)
    if ($new_password && $confirm_password) {
        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "New password and confirmation do not match.";
            header("Location: ../my-account.php");
            exit;
        }
    }

    // Initialize database and customer object
    $database = new Database();
    $db = $database->getConnection();
    $customer = new Customer($db);

    // Find customer by ID
    $customer->customer_id = $customer_id;
    if (!$customer->findById()) {
        $_SESSION['error_message'] = "Customer not found.";
        header("Location: ../my-account.php");
        exit;
    }

    // Set new values
    $customer->first_name = $first_name;
    $customer->last_name = $last_name;
    $customer->email = $email;
    $customer->phone_number = $phone_number;
    $customer->address = $address;

    // Attempt to update
    $update_status = $customer->update($new_password, $current_password);

    if ($update_status === "incorrect_password") {
        $_SESSION['error_message'] = "Current password is incorrect.";
    } elseif ($update_status === "success") {
        $_SESSION['success_message'] = "Contact information updated successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to update information.";
    }

    header("Location: ../my-account.php");
    exit;
}
?>
