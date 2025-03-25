<?php
include '../classes/database.php';
include '../classes/wishlist.php';
session_start();

// Return JSON response
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status" => "error", "message" => "Please log in to add products to your wishlist."]);
    exit();
}

// Check if product_id is provided
if (!isset($_POST['product_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
    exit();
}

$database = new Database();
$db = $database->getConnection();
$wishlist = new Wishlist($db);

$wishlist->customer_id = $_SESSION['customer_id'];
$wishlist->product_id = $_POST['product_id'];

// Check if the product is already in the wishlist
if ($wishlist->isProductInWishlist()) {
    echo json_encode(["status" => "error", "message" => "Product is already in your wishlist."]);
    exit();
}

// Add product to wishlist
if ($wishlist->addToWishlist()) {
    echo json_encode(["status" => "success", "message" => "Product added to wishlist!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add product to wishlist."]);
}
?>
