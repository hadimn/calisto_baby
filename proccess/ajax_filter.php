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
$tag_filter = isset($_GET['tag']) ? (array)$_GET['tag'] : [];
$special_filter = isset($_GET['special']) ? $_GET['special'] : '';
$search_term = isset($_GET['search']) ? $_GET['search'] : null;

// Calculate offset for pagination
$offset = ($page - 1) * $limit;

// Build the base query with GROUP_CONCAT to get colors
$query = "SELECT p.*, 
                 GROUP_CONCAT(DISTINCT ps.color) as colors 
          FROM products p
          LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
          WHERE 1=1";
$params = [];

// Apply filters
if (!empty($tag_filter)) {
    $placeholders = implode(',', array_fill(0, count($tag_filter), '?'));
    $query .= " AND p.product_id IN (SELECT product_id FROM product_tags WHERE tag_id IN ($placeholders))";
    $params = array_merge($params, $tag_filter);
}

// Apply special filter
if ($special_filter) {
    switch ($special_filter) {
        case 'on-sale':
            $query .= " AND p.new_price < p.price";
            break;
        case 'best-deal':
            $query .= " AND (p.price - p.new_price) / p.price >= 0.2";
            break;
        case 'popular':
            $query .= " AND p.product_id IN (
                SELECT product_id FROM order_items 
                GROUP BY product_id 
                HAVING COUNT(*) > 5
            )";
            break;
    }
}

if ($search_term) {
    $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $searchTermWithWildcards = "%" . $search_term . "%";
    array_push($params, $searchTermWithWildcards, $searchTermWithWildcards);
}

// Group by product_id to avoid duplicates
$query .= " GROUP BY p.product_id";

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

// Process the colors for each product
foreach ($products as &$product) {
    if ($product['colors']) {
        $product['colors'] = explode(',', $product['colors']);
    } else {
        $product['colors'] = [];
    }
}

// Get total number of products for pagination
$total_query = "SELECT COUNT(DISTINCT p.product_id) as total 
                FROM products p
                WHERE 1=1";
$total_params = [];

if (!empty($tag_filter)) {
    $placeholders = implode(',', array_fill(0, count($tag_filter), '?'));
    $total_query .= " AND p.product_id IN (SELECT product_id FROM product_tags WHERE tag_id IN ($placeholders))";
    $total_params = array_merge($total_params, $tag_filter);
}

if ($special_filter) {
    switch ($special_filter) {
        case 'on-sale':
            $total_query .= " AND p.new_price < p.price";
            break;
        case 'best-deal':
            $total_query .= " AND (p.price - p.new_price) / p.price >= 0.2";
            break;
        case 'popular':
            $total_query .= " AND p.product_id IN (
                SELECT product_id FROM order_items 
                GROUP BY product_id 
                HAVING COUNT(*) > 5
            )";
            break;
    }
}

if ($search_term) {
    $total_query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
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
        'tags' => $tag_filter,
        'special' => $special_filter
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
