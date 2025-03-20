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

        if (isset($data['product_id'], $data['quantity'], $data['color'], $data['size'])) {
            $product_id = $data['product_id'];
            $quantity = $data['quantity'];
            $color = $data['color'];
            $size = $data['size'];

            if (!isset($_SESSION['customer_id'])) {
                throw new Exception("Customer ID not set in session.");
            }
            $customer_id = $_SESSION['customer_id'];

            // Include database and cart class files
            include '../classes/database.php';
            include '../classes/cart.php';
            include '../classes/product.php'; // Include the Product class to check stock

            // Connect to the database
            $database = new Database();
            $db = $database->getConnection();

            // Instantiate product class to check stock
            $product = new Product($db);
            $product->product_id = $product_id;
            $availableStock = $product->getStockForSizeAndColor($size, $color);

            if ($availableStock === false) {
                throw new Exception("Invalid product, size, or color.");
            }

            // Check if the product is out of stock
            if ($availableStock <= 0) {
                throw new Exception("This product is out of stock for the selected size and color.");
            }

            // Instantiate cart class
            $cart = new Cart($db);
            $cart->customer_id = $customer_id;
            $cart->product_id = $product_id;
            $cart->quantity = $quantity;
            $cart->color = $color;
            $cart->size = $size;

            // Fetch the current quantity of this product in the cart for the selected size and color
            $currentCartQuantity = $cart->getCartQuantityForProduct($product_id, $size, $color);

            // Check if the user has already added the entire stock to their cart
            if ($currentCartQuantity >= $availableStock) {
                echo json_encode([
                    'success' => false,
                    'message' => 'You have already added the whole stock to your cart. Do you want to go to the cart and proceed with your order?',
                    'redirect' => true // Flag to indicate that the user should be redirected to the cart
                ]);
                exit();
            }

            // Calculate the total quantity after adding the new quantity
            $totalQuantity = $currentCartQuantity + $quantity;

            // Check if the total quantity exceeds the available stock
            if ($totalQuantity > $availableStock) {
                throw new Exception("Requested quantity exceeds available stock. Remaining stock: " . ($availableStock - $currentCartQuantity));
            }

            // Add the product to the cart
            if ($cart->add()) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Failed to add product to cart.");
            }
        } else {
            throw new Exception("Missing required fields in request.");
        }
    } else {
        throw new Exception("Invalid request method or content type.");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    error_log("Cart update error: " . $e->getMessage()); // Log the error
}
