<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'count' => 0]);
    exit();
}

include 'classes/database.php';
include 'classes/cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$cart->customer_id = $_SESSION['customer_id'];
$count = $cart->getCartCount();

echo json_encode(['success' => true, 'count' => $count]);
?>