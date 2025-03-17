<?php
session_start();
include '../classes/database.php';
include '../classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to be logged in.']);
    exit;
}

if (!isset($_GET['cart_id'])) {
    echo json_encode(['success' => false, 'message' => 'Cart ID is required.']);
    exit;
}

$cart_id = $_GET['cart_id'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Remove the cart item
$cart = new Cart($db);
if ($cart->removeItem($cart_id)) {
    echo json_encode(['success' => true, 'message' => 'Item removed from cart.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart.']);
}


?>