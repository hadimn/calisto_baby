<?php
session_start();
include '../classes/database.php';
include '../classes/product.php';
include '../classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = 'you need to be logged in.';
    header('Location: index.php');
}

$customer_id = $_SESSION['customer_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$color = $_POST['color'];
$size = $_POST['size'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check stock availability
$product = new Product($db);
$product->product_id = $product_id;
$stock = $product->getStockForSizeAndColor($size, $color);

if ($stock < $quantity) {
    die("Not enough stock available for the selected size and color.");
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
    header("Location: ../cart.php");
} else {
    die("Failed to add product to cart.");
}
