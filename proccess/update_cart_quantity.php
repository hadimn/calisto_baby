<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the response header to JSON
header('Content-Type: application/json');

try {
    // Check if the request is POST and JSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        // Decode the JSON data
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['cart_id']) && isset($data['quantity'])) {
            $cart_id = $data['cart_id'];
            $quantity = $data['quantity'];

            if (!isset($_SESSION['customer_id'])) {
                throw new Exception("Customer ID not set in session.");
            }
            $customer_id = $_SESSION['customer_id'];

            // Include database and cart class files
            include '../classes/database.php';
            include '../classes/cart.php';

            // Connect to the database
            $database = new Database();
            $db = $database->getConnection();

            // Instantiate cart class
            $cart = new Cart($db);
            $cart->cart_id = $cart_id;
            $cart->quantity = $quantity;

            if ($cart->updateQuantity()) {
                // Calculate totals.
                $totals = $cart->calculateCartTotals($customer_id);
                $item_subtotal = $cart->getCartItemSubtotal($cart_id);

                echo json_encode([
                    'success' => true,
                    'subtotal' => $totals['subtotal'],
                    'total' => $totals['total'],
                    'item_subtotal' => $item_subtotal
                ]);
            } else {
                throw new Exception("Failed to update quantity in the database.");
            }
        } else {
            throw new Exception("Missing cart_id or quantity in request.");
        }
    } else {
        throw new Exception("Invalid request method or content type.");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    error_log("Cart update error: " . $e->getMessage()); // Log the error
}
