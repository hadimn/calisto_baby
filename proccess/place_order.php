<?php
// process_order.php

use Classes\Order;
use Classes\OrderItem;

session_start();
include '../classes/database.php';
include '../classes/cart.php';
include '../classes/customer.php';
include '../classes/billing_address.php';
include '../classes/order.php';
include '../classes/order-items.php';
@include('proccess/shipping_proccess.php');

$database = new Database();
$db = $database->getConnection();

// Verify required POST data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['place_order'])) {
    header("Location: checkout.php?error=invalid_request");
    exit();
}

// Verify terms acceptance
if (!isset($_POST['accept_terms'])) {
    header("Location: checkout.php?error=terms_not_accepted");
    exit();
}

// Get customer data
$customer = new Customer($db);
$customer->customer_id = $_SESSION['customer_id'];
$customer->findById();

// Get cart data
$cart = new Cart($db);
$cart->customer_id = $_SESSION['customer_id'];
$cartItems = $cart->getItems()->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartItems)) {
    header("Location: checkout.php?error=empty_cart");
    exit();
}

// Calculate totals
$totals = $cart->calculateCartTotals($_SESSION['customer_id']);
$subtotal = $totals['subtotal'];
$total = $totals['total'];

// Get shipping fee
$query = "SELECT fee FROM shipping_fees LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$current_fee = $row ? ($total < 99 ? $row['fee'] : '0.00') : '0.00';

// Calculate discount if any
$discount = new Discount($db);
$discount->customer_id = $_SESSION['customer_id'];
$activeDiscount = $discount->getActiveDiscount();

$discountAmount = 0;
if ($activeDiscount) {
    $discountAmount = ($subtotal * $activeDiscount['discount_percentage']) / 100;
}

$grandTotal = ($total - $discountAmount) + $current_fee;

// Save billing address
$billingAddress = new BillingAddress($db);
$billingAddress->customer_id = $_SESSION['customer_id'];
$billingAddress->first_name = $_POST['first_name'];
$billingAddress->last_name = $_POST['last_name'];
$billingAddress->email = $_POST['email'];
$billingAddress->phone_number = $_POST['phone_number'];
$billingAddress->address = $_POST['address'];
$billingAddress->country = $_POST['country'];
$billingAddress->city = $_POST['city'];
$billingAddress->additional_info = $_POST['additional_info'];

if (!$billingAddress->save()) {
    header("Location: checkout.php?error=address_error");
    exit();
}


// Fetch the current shipping fee from the database
$query = "SELECT fee FROM shipping_fees LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$shipping_fee = isset($row) ? ($total < 99 ? $row['fee'] : '0.00') : '0.00';

// Create order
$order = new Order($db);
$order->customer_id = $_SESSION['customer_id'];
$order->total_amount = $total;
$order->discount_amount = $discountAmount;
$order->shipping_fee = $shipping_fee;
$order->currency = 'USD';
$order->status = 'pending';
$order->created_at = date('Y-m-d H:i:s');

if ($order->create()) {
    $order_id = $db->lastInsertId();

    // Add order items
    foreach ($cartItems as $item) {
        $orderItem = new OrderItem($db);
        $orderItem->order_id = $order_id;
        $orderItem->product_id = $item['product_id'];
        $orderItem->product_size_id = $item['product_size_id'];
        $orderItem->quantity = $item['quantity'];
        $orderItem->price_at_purchase = ($item['new_price'] > 0) ? $item['new_price'] : $item['price'];

        if (!$orderItem->create()) {
            error_log("Error creating order item for order: $order_id");
        }

        // 🔽 Add this to reduce stock
        $stockUpdateQuery = "UPDATE product_sizes SET stock = stock - :quantity 
                             WHERE id = :product_size_id AND stock >= :quantity";
        $stockStmt = $db->prepare($stockUpdateQuery);
        $stockStmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
        $stockStmt->bindParam(':product_size_id', $item['product_size_id'], PDO::PARAM_INT);

        if (!$stockStmt->execute() || $stockStmt->rowCount() === 0) {
            error_log("Stock update failed or insufficient stock for size ID: " . $item['product_size_id']);
            // Optionally: Roll back the order creation here
        }
    }


    // Deactivate first-order discount if it was used
    if ($activeDiscount && $activeDiscount['discount_type'] === 'first_order') {
        $discount = new Discount($db);
        $discount->customer_id = $_SESSION['customer_id'];
        $discount->deactivateFirstOrderDiscount();
    }


    // Clear the cart
    if (!$cart->clearCart($_SESSION['customer_id'])) {
        error_log("Error clearing cart for customer: " . $_SESSION['customer_id']);
    }

    // Redirect to success page
    header("Location: ../my-account.php#orders");
    exit();
} else {
    header("Location: checkout.php?error=order_error");
    exit();
}
