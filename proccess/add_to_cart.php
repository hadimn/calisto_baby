<?php
session_start();
include '../classes/database.php';
include '../classes/product.php';
include '../classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to be logged in.']);
    exit;
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

$customer_id = $_SESSION['customer_id'];
$product_id = $data['product_id'];
$quantity = $data['quantity'];
$color = $data['color'];
$size = $data['size'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check stock availability
$product = new Product($db);
$product->product_id = $product_id;
$stock = $product->getStockForSizeAndColor($size, $color);

if ($stock < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Not enough stock available for the selected size and color.']);
    exit;
}

// Add to cart
$cart = new Cart($db);
$cart->customer_id = $customer_id;
$cart->product_id = $product_id;
$cart->quantity = $quantity;
$cart->color = $color;
$cart->size = $size;
$cart->added_at = date('Y-m-d H:i:s');

if ($cart->add()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
}