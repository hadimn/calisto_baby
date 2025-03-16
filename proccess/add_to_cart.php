<?php
session_start();
include '../classes/database.php';
include '../classes/cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['product_id']) || empty($_POST['quantity']) || empty($_POST['color']) || empty($_POST['size'])) {
        die("Please fill all the fields.");
    }

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $color = htmlspecialchars($_POST['color']);
    $size = htmlspecialchars($_POST['size']);

    // Assuming you have a logged-in user
    if (!isset($_SESSION['customer_id'])) {
        die("You need to be logged in to add products to the cart.");
    }

    $customer_id = $_SESSION['customer_id'];

    // Connect to the database
    $database = new Database();
    $db = $database->getConnection();

    // Create a new Cart instance
    $cart = new Cart($db);
    $cart->customer_id = $customer_id;
    $cart->product_id = $product_id;
    $cart->quantity = $quantity;
    $cart->color = $color;
    $cart->size = $size;
    $cart->added_at = date('Y-m-d H:i:s');

    // Add the product to the cart
    if ($cart->add()) {
        header("Location: ../cart.php"); // Redirect to the cart page
        exit();
    } else {
        die("There was an error adding the product to the cart.");
    }
} else {
    die("Invalid request method.");
}
?>