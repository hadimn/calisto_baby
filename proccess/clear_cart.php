<?php
session_start();
include '../classes/database.php';
include '../classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to be logged in.']);
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Clear the cart
$cart = new Cart($db);
if ($cart->clearCart($customer_id)) {
    echo json_encode(['success' => true, 'message' => 'Cart cleared successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to clear cart.']);
}



?>