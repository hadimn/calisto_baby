<?php

include 'classes/cart.php';
include 'classes/database.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$cart->customer_id = 3; // Replace with a valid customer ID
$totals = $cart->calculateCartTotals($cart->customer_id);
print_r($totals); // Check if the subtotal and total are calculated correctly

?>