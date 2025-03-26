<?php
include '../classes/database.php';
include '../classes/tag.php';
include '../classes/product.php';

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);
$product = new Product($db);

// Fetch filters from the request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at DESC';
$color_filter = isset($_GET['color']) ? (array)$_GET['color'] : [];
$tag_filter = isset($_GET['tag']) ? (array)$_GET['tag'] : [];
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
$search_term = isset($_GET['search']) ? $_GET['search'] : null;

// Calculate offset for pagination
$offset = ($page - 1) * $limit;

// Build the base query
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

// Apply filters
if (!empty($color_filter)) {
    $placeholders = implode(',', array_fill(0, count($color_filter), '?'));
    $query .= " AND product_id IN (SELECT product_id FROM product_sizes WHERE color IN ($placeholders))";
    $params = array_merge($params, $color_filter);
}
if (!empty($tag_filter)) {
    $placeholders = implode(',', array_fill(0, count($tag_filter), '?'));
    $query .= " AND product_id IN (SELECT product_id FROM product_tags WHERE tag_id IN ($placeholders))";
    $params = array_merge($params, $tag_filter);
}
if ($min_price !== null && $max_price !== null) {
    $query .= " AND ((price BETWEEN ? AND ?) OR (new_price BETWEEN ? AND ?))";
    array_push($params, $min_price, $max_price, $min_price, $max_price);
}
if ($search_term) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $searchTermWithWildcards = "%" . $search_term . "%";
    array_push($params, $searchTermWithWildcards, $searchTermWithWildcards);
}

// Apply sorting
$query .= " ORDER BY " . $sort;

// Add pagination
$query .= " LIMIT ? OFFSET ?";
array_push($params, $limit, $offset);

// Prepare and execute the query
$stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $param_type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindValue($key + 1, $value, $param_type);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get additional product details (tags and colors) for each product
foreach ($products as &$product_item) {
    $product_obj = new Product($db);
    $product_obj->product_id = $product_item['product_id'];
    
    // Get tags for the product
    // $product_item['tags'] = $product_obj->getTags();
    
    // Get available colors for the product
    $product_item['colors'] = $product_obj->getAvailableColorsById($product_item['product_id']);
    
    // Get available sizes for the product (optional)
    $product_item['sizes'] = $product_obj->getAvailableSizesById($product_item['product_id']);
}

// Get total number of products for pagination
$total_query = "SELECT COUNT(*) as total FROM products WHERE 1=1";
$total_params = [];

if (!empty($color_filter)) {
    $placeholders = implode(',', array_fill(0, count($color_filter), '?'));
    $total_query .= " AND product_id IN (SELECT product_id FROM product_sizes WHERE color IN ($placeholders))";
    $total_params = array_merge($total_params, $color_filter);
}
if (!empty($tag_filter)) {
    $placeholders = implode(',', array_fill(0, count($tag_filter), '?'));
    $total_query .= " AND product_id IN (SELECT product_id FROM product_tags WHERE tag_id IN ($placeholders))";
    $total_params = array_merge($total_params, $tag_filter);
}
if ($min_price !== null && $max_price !== null) {
    $total_query .= " AND ((price BETWEEN ? AND ?) OR (new_price BETWEEN ? AND ?))";
    array_push($total_params, $min_price, $max_price, $min_price, $max_price);
}
if ($search_term) {
    $total_query .= " AND (name LIKE ? OR description LIKE ?)";
    $searchTermWithWildcards = "%" . $search_term . "%";
    array_push($total_params, $searchTermWithWildcards, $searchTermWithWildcards);
}

$total_stmt = $db->prepare($total_query);
foreach ($total_params as $key => $value) {
    $param_type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $total_stmt->bindValue($key + 1, $value, $param_type);
}
$total_stmt->execute();
$total_products = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_products / $limit);

// Prepare response
$response = [
    'products' => $products,
    'pagination' => [
        'total_products' => $total_products,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'limit' => $limit
    ],
    'filters' => [
        'sort' => $sort,
        'colors' => $color_filter,
        'tags' => $tag_filter,
        'min_price' => $min_price,
        'max_price' => $max_price
    ]
];

header('Content-Type: application/json');
echo json_encode($response);