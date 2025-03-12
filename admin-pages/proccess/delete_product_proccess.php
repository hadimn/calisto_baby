<?php
include "../../classes/database.php";
include "../../classes/product.php";

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Delete product logic
if (isset($_GET['delete_id'])) {
    $product->product_id = $_GET['delete_id'];
    try {
        $delete_query = "DELETE FROM products WHERE product_id = :product_id";
        $delete_stmt = $db->prepare($delete_query);
        $delete_stmt->bindParam(":product_id", $product->product_id);
        if ($delete_stmt->execute()) {
            $delete_sizes_query = "DELETE FROM product_sizes WHERE product_id = :product_id";
            $delete_sizes_stmt = $db->prepare($delete_sizes_query);
            $delete_sizes_stmt->bindParam(":product_id", $product->product_id);
            $delete_sizes_stmt->execute();
            $_SESSION['success'] = "Product deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete product.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
    header("Location: ../index.php?file=productpage.php");
    exit();
}
