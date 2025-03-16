<?php
session_start();
include 'classes/database.php';
include 'classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    die("You need to be logged in to view the cart.");
}

$customer_id = $_SESSION['customer_id'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Fetch cart items
$cart = new Cart($db);
$cart->customer_id = $customer_id;
$stmt = $cart->getItems();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate cart totals
$totals = $cart->calculateCartTotals($customer_id);
$subtotal = $totals['subtotal'];
$total = $totals['total'];

session_abort();
?>