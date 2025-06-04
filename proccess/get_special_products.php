<?php
include '../classes/database.php';
include '../classes/product.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Get parameters
$type = isset($_GET['type']) ? $_GET['type'] : 'popular';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
$offset = ($page - 1) * $limit;

// Get products based on type
switch($type) {
    case 'best-deal':
        $products = $product->getPorductsBestDeal();
        $total_products = count($products);
        $products = array_slice($products, $offset, $limit);
        break;
    case 'on-sale':
        $products = $product->getPorductsOnSale();
        $total_products = count($products);
        $products = array_slice($products, $offset, $limit);
        break;
    case 'popular':
    default:
        $products = $product->getPorductsPopular();
        $total_products = count($products);
        $products = array_slice($products, $offset, $limit);
        break;
}

// Calculate total pages
$total_pages = ceil($total_products / $limit);

// Return JSON response with product data
echo json_encode([
    'products' => $products,
    'pagination' => [
        'total_pages' => $total_pages,
        'current_page' => $page
    ]
]);