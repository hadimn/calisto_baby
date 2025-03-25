<?php
include 'classes/database.php';
include 'classes/cart.php';
include 'classes/tag.php';
include 'classes/product.php';

$database = new Database();
$db = $database->getConnection();
$tag = new Tag($db);
$tags = $tag->getProductCountPerTag();

$product = new Product($db);
$colors = $product->getAvailableColors();

// Initial values for filters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at DESC';
$color_filter = isset($_GET['color']) ? (array)$_GET['color'] : [];
$tag_filter = isset($_GET['tag']) ? (array)$_GET['tag'] : [];
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
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

    <style>
        /* Checkbox list styles */
        .checkbox-list {
            list-style: none;
            padding-left: 0;
        }

        .checkbox-list li {
            margin-bottom: 8px;
        }

        .checkbox-list label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-list input[type="checkbox"] {
            margin-right: 10px;
        }

        .checkbox-list .color {
            display: inline-block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-right: 8px;
        }

        /* Filter buttons */
        .apply-filters-btn {
            background: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            width: 100%;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .apply-filters-btn:hover {
            background: #555;
        }

        .clear-filters-btn {
            display: block;
            text-align: center;
            color: #333;
            text-decoration: underline;
        }

        .clear-filters-btn:hover {
            color: #555;
        }

        /* Add loading spinner style */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner img {
            width: 50px;
        }
    </style>
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

                            <!-- Products container -->
                            <div class="col-12" id="products-container">
                                <div class="loading-spinner">
                                    <img src="assets/images/icons/loading.gif" alt="Loading...">
                                </div>
                                <div class="row" id="products-row">
                                    <!-- Products will be loaded here via AJAX -->
                                </div>
                            </div>

                            <!-- Pagination container -->
                            <div class="col-12" id="pagination-container">
                                <!-- Pagination will be loaded here via AJAX -->
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-12 order-2 order-lg-1 mb-40">
                        <form id="filter-form" method="get">
                            <!-- Hidden fields to maintain pagination and sorting -->
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="limit" value="<?= htmlspecialchars($limit) ?>">
                            <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">

                            <!-- Category Filter -->
                            <div class="sidebar">
                                <h4 class="sidebar-title">Category</h4>
                                <ul class="list-group">
                                    <?php foreach ($tags as $tag): ?>
                                        <li class="list-group-item border-0 py-2 px-0">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" name="tag[]" value="<?= $tag['tag_id'] ?>"
                                                        <?= in_array($tag['tag_id'], $tag_filter) ? 'checked' : '' ?> id="tag-<?= $tag['tag_id'] ?>">
                                                    <label class="form-check-label" for="tag-<?= $tag['tag_id'] ?>">
                                                        <?= $tag['name'] ?>
                                                    </label>
                                                </div>
                                                <span class="badge rounded-pill ms-2" style="background-color: #94c7eb;"><?= $tag['product_count'] ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Color Filter -->
                            <div class="sidebar">
                                <h4 class="sidebar-title">Colors</h4>
                                <ul class="sidebar-list checkbox-list">
                                    <?php foreach ($colors as $color): ?>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="color[]" value="<?= $color ?>"
                                                    <?= in_array($color, $color_filter) ? 'checked' : '' ?>>
                                                <span class="color" style="background-color: <?= $color ?>"></span> <?= $color ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Price Filter -->
                            <div class="sidebar">
                                <h3 class="sidebar-title">Price</h3>
                                <div class="sidebar-price">
                                    <div id="price-range"></div>
                                    <input type="text" id="price-amount" readonly>
                                    <input type="hidden" id="min-price" name="min_price" value="<?= $min_price ?>">
                                    <input type="hidden" id="max-price" name="max_price" value="<?= $max_price ?>">
                                </div>
                            </div>

                            <!-- Apply Filters Button -->
                            <div class="sidebar">
                                <button type="submit" class="apply-filters-btn">Apply Filters</button>
                                <?php if (!empty($color_filter) || !empty($tag_filter) || $min_price !== null || $max_price !== null): ?>
                                    <a href="?" class="clear-filters-btn">Clear All Filters</a>
                                <?php endif; ?>
                            </div>
                        </form>
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
        $(document).ready(function() {
            // Initialize price slider
            $("#price-range").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [<?= $min_price !== null ? $min_price : 0 ?>, <?= $max_price !== null ? $max_price : 1000 ?>],
                slide: function(event, ui) {
                    $("#price-amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                    $("#min-price").val(ui.values[0]);
                    $("#max-price").val(ui.values[1]);
                }
            });
            $("#price-amount").val("$" + $("#price-range").slider("values", 0) +
                " - $" + $("#price-range").slider("values", 1));

            // Function to load products via AJAX
            function loadProducts() {
                const formData = $('#filter-form').serialize();
                const urlParams = new URLSearchParams(window.location.search);

                // Show loading spinner
                $('#products-row').hide();
                $('.loading-spinner').show();

                $.ajax({
                    url: 'proccess/ajax_filter.php?' + formData,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Update URL without reloading
                        const newUrl = window.location.pathname + '?' + formData;
                        window.history.pushState({
                            path: newUrl
                        }, '', newUrl);

                        // Render products
                        renderProducts(response.products);

                        // Render pagination
                        renderPagination(response.pagination);

                        // Hide loading spinner
                        $('.loading-spinner').hide();
                        $('#products-row').show();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('.loading-spinner').hide();
                        $('#products-row').html('<div class="col-12 text-center"><p>Error loading products. Please try again.</p></div>').show();
                    }
                });
            }

            // Function to render products
            function renderProducts(products) {
                let html = '';

                if (products.length === 0) {
                    html = '<div class="col-12 text-center"><p>No products found matching your criteria.</p></div>';
                } else {
                    products.forEach(product => {
                        html += `
                <div class="col-xl-4 col-md-6 col-12 mb-40">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="admin-pages/${product.image}" alt="${product.name}">
                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        <button class="add-to-cart" data-id="${product.product_id}">add to cart</button>
                                        <button>add to wishlist</button>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <div class="content-left">
                                    <h4 class="title"><a href="single-product.php?product_id=${product.product_id}">${product.name}</a></h4>
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
                                    <span class="price">$${product.new_price} <span class="old">$${product.price}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                    });
                }

                $('#products-row').html(html);
            }

            // Function to render pagination
            function renderPagination(pagination) {
                let html = '';
                const currentPage = pagination.current_page;
                const totalPages = pagination.total_pages;

                if (totalPages > 1) {
                    html = '<ul class="page-pagination">';

                    // Previous button
                    if (currentPage > 1) {
                        html += `<li><a href="#" data-page="${currentPage - 1}">«</a></li>`;
                    }

                    // Page numbers
                    for (let i = 1; i <= totalPages; i++) {
                        html += `<li class="${i == currentPage ? 'active' : ''}"><a href="#" data-page="${i}">${i}</a></li>`;
                    }

                    // Next button
                    if (currentPage < totalPages) {
                        html += `<li><a href="#" data-page="${currentPage + 1}">»</a></li>`;
                    }

                    html += '</ul>';
                }

                $('#pagination-container').html(html);
            }

            // Initial load
            loadProducts();

            // Handle form submission
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                // Reset to page 1 when filters change
                $('input[name="page"]').val(1);
                loadProducts();
            });

            // Handle pagination clicks
            $(document).on('click', '.page-pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                $('input[name="page"]').val(page);
                loadProducts();
            });

            // Handle limit change
            $('#limit-select').change(function() {
                $('input[name="limit"]').val($(this).val());
                $('input[name="page"]').val(1); // Reset to page 1
                loadProducts();
            });

            // Handle sort change
            $('#sort-select').change(function() {
                $('input[name="sort"]').val($(this).val());
                $('input[name="page"]').val(1); // Reset to page 1
                loadProducts();
            });
        });
    </script>

</body>

</html>