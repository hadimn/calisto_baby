<?php
include '../classes/database.php';
include '../classes/product.php';

$data = json_decode(file_get_contents('php://input'), true);

$product_id = $data['product_id'];
$color = $data['color'];
$size = $data['size'];

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->product_id = $product_id;
$stock = $product->getStockForSizeAndColor($size, $color);

echo json_encode(['stock' => $stock]);
?>