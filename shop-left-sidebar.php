<?php
include 'classes/database.php';
include 'classes/cart.php';
include 'classes/tag.php';
include 'classes/product.php';

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);

// Fetch tags from the database
$tags = $tag->getProductCountPerTag();

$product = new Product($db);
$colors = $product->getAvailableColors();

// Handle filters, pagination, and sorting
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at DESC';
$color_filter = isset($_GET['color']) ? $_GET['color'] : null;
$tag_filter = isset($_GET['tag']) ? (int)$_GET['tag'] : null;
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;

// Calculate offset for pagination
$offset = ($page - 1) * $limit;

// Build the base query
$query = "SELECT * FROM products WHERE 1=1";

// Apply filters
if ($color_filter) {
    $query .= " AND product_id IN (SELECT product_id FROM product_sizes WHERE color = :color)";
}
if ($tag_filter) {
    $query .= " AND product_id IN (SELECT product_id FROM product_tags WHERE tag_id = :tag_id)";
}
if ($min_price !== null && $max_price !== null) {
    $query .= " AND (price BETWEEN :min_price AND :max_price)";
}

// Apply sorting
$query .= " ORDER BY " . $sort;

// Add pagination
$query .= " LIMIT :limit OFFSET :offset";

// Prepare and execute the query
$stmt = $db->prepare($query);

if ($color_filter) {
    $stmt->bindParam(":color", $color_filter);
}
if ($tag_filter) {
    $stmt->bindParam(":tag_id", $tag_filter, PDO::PARAM_INT);
}
if ($min_price !== null && $max_price !== null) {
    $stmt->bindParam(":min_price", $min_price);
    $stmt->bindParam(":max_price", $max_price);
}

$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of products for pagination
$total_query = "SELECT COUNT(*) as total FROM products WHERE 1=1";
if ($color_filter) {
    $total_query .= " AND product_id IN (SELECT product_id FROM product_sizes WHERE color = :color)";
}
if ($tag_filter) {
    $total_query .= " AND product_id IN (SELECT product_id FROM product_tags WHERE tag_id = :tag_id)";
}
if ($min_price !== null && $max_price !== null) {
    $total_query .= " AND (price BETWEEN :min_price AND :max_price)";
}

$total_stmt = $db->prepare($total_query);

if ($color_filter) {
    $total_stmt->bindParam(":color", $color_filter);
}
if ($tag_filter) {
    $total_stmt->bindParam(":tag_id", $tag_filter, PDO::PARAM_INT);
}
if ($min_price !== null && $max_price !== null) {
    $total_stmt->bindParam(":min_price", $min_price);
    $total_stmt->bindParam(":max_price", $max_price);
}

$total_stmt->execute();
$total_products = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_products / $limit);
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Jadusona - eCommerce Baby shop Bootstrap5 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icon-font.min.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/helper.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
</head>

<body>

    <div class="main-wrapper">

        <?php include 'header.php'; ?>

        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/shopPage.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">
                        <h1>Shop</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="shop-left-sidebar.html">Shop</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row row-30 mbn-40">

                    <div class="col-xl-9 col-lg-8 col-12 order-1 order-lg-2 mb-40">
                        <div class="row">

                            <div class="col-12">
                                <div class="product-show">
                                    <h4>Show:</h4>
                                    <select class="nice-select" id="limit-select">
                                        <option value="8" <?= $limit == 8 ? 'selected' : '' ?>>8</option>
                                        <option value="12" <?= $limit == 12 ? 'selected' : '' ?>>12</option>
                                        <option value="16" <?= $limit == 16 ? 'selected' : '' ?>>16</option>
                                        <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                                    </select>
                                </div>
                                <div class="product-short">
                                    <h4>Sort by:</h4>
                                    <select class="nice-select" id="sort-select">
                                        <option value="name ASC" <?= $sort == 'name ASC' ? 'selected' : '' ?>>Name Ascending</option>
                                        <option value="name DESC" <?= $sort == 'name DESC' ? 'selected' : '' ?>>Name Descending</option>
                                        <option value="created_at ASC" <?= $sort == 'created_at ASC' ? 'selected' : '' ?>>Date Ascending</option>
                                        <option value="created_at DESC" <?= $sort == 'created_at DESC' ? 'selected' : '' ?>>Date Descending</option>
                                        <option value="price ASC" <?= $sort == 'price ASC' ? 'selected' : '' ?>>Price Ascending</option>
                                        <option value="price DESC" <?= $sort == 'price DESC' ? 'selected' : '' ?>>Price Descending</option>
                                    </select>
                                </div>
                            </div>

                            <?php foreach ($products as $product): ?>
                                <div class="col-xl-4 col-md-6 col-12 mb-40">
                                    <div class="product-item">
                                        <div class="product-inner">
                                            <div class="image">
                                                <img src="admin-pages/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                                <div class="image-overlay">
                                                    <div class="action-buttons">
                                                        <button>add to cart</button>
                                                        <button>add to wishlist</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="content-left">
                                                    <h4 class="title"><a href="single-product.php?product_id=<?= $product['product_id'] ?>"><?= $product['name'] ?></a></h4>
                                                    <div class="ratting">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                                    <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span style="background-color: #0271bc"></span><span style="background-color: #efc87c"></span><span style="background-color: #00c183"></span></h5>
                                                </div>
                                                <div class="content-right">
                                                    <span class="price">$<?= $product['new_price'] ?> <span class="old">$<?= $product['price'] ?></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="col-12">
                                <ul class="page-pagination">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="<?= $i == $page ? 'active' : '' ?>">
                                            <a href="?page=<?= $i ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&color=<?= $color_filter ?>&tag=<?= $tag_filter ?>&min_price=<?= $min_price ?>&max_price=<?= $max_price ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-12 order-2 order-lg-1 mb-40">

                        <div class="sidebar">
                            <h4 class="sidebar-title">Category</h4>
                            <ul class="sidebar-list">
                                <?php foreach ($tags as $tag): ?>
                                    <li><a href="?tag=<?= $tag['tag_id'] ?>"><?= $tag['name'] ?> <span class="num"><?= $tag['product_count'] ?></span></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="sidebar">
                            <h4 class="sidebar-title">Colors</h4>
                            <ul class="sidebar-list">
                                <?php foreach ($colors as $color): ?>
                                    <li><a href="?color=<?= $color ?>"><span class="color" style="background-color: <?= $color ?>"></span> <?= $color ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="sidebar">
                            <h3 class="sidebar-title">Price</h3>
                            <div class="sidebar-price">
                                <div id="price-range"></div>
                                <input type="text" id="price-amount" readonly>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div><!-- Page Section End -->

        <!-- Brand Section Start -->
        <div class="brand-section section section-padding pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="brand-slider">
                        <div class="brand-item col"><img src="assets/images/brands/brand-1.png" alt=""></div>
                        <div class="brand-item col"><img src="assets/images/brands/brand-2.png" alt=""></div>
                        <div class="brand-item col"><img src="assets/images/brands/brand-3.png" alt=""></div>
                        <div class="brand-item col"><img src="assets/images/brands/brand-4.png" alt=""></div>
                        <div class="brand-item col"><img src="assets/images/brands/brand-5.png" alt=""></div>
                        <div class="brand-item col"><img src="assets/images/brands/brand-6.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div><!-- Brand Section End -->

        <?php include 'footer.php'; ?>

    </div>

    <!-- JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // Handle limit and sort changes
        document.getElementById('limit-select').addEventListener('change', function() {
            const limit = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('limit', limit);
            window.location.href = url.toString();
        });

        document.getElementById('sort-select').addEventListener('change', function() {
            const sort = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            window.location.href = url.toString();
        });

        $(function() {
            $("#price-range").slider({
                range: true,
                min: 0,
                max: 1000, // Adjust max value as needed
                values: [<?= $min_price !== null ? $min_price : 0 ?>, <?= $max_price !== null ? $max_price : 1000 ?>], // set the default values
                slide: function(event, ui) {
                    $("#price-amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                },
                stop: function(event, ui) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('min_price', ui.values[0]);
                    url.searchParams.set('max_price', ui.values[1]);
                    window.location.href = url.toString();
                }
            });
            $("#price-amount").val("$" + $("#price-range").slider("values", 0) +
                " - $" + $("#price-range").slider("values", 1));
        });
    </script>

</body>

</html>