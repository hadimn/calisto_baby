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

// Get the type parameter from URL
$type = isset($_GET['type']) ? $_GET['type'] : 'popular';
$valid_types = ['popular', 'best-deal', 'on-sale'];
if (!in_array($type, $valid_types)) {
    $type = 'popular';
}

// Set page title based on type
$page_titles = [
    'popular' => 'Popular Products',
    'best-deal' => 'Best Deals',
    'on-sale' => 'On Sale Products'
];
$page_title = $page_titles[$type];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Jadusona - <?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        .product-item .image .sale-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff4b4b;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            z-index: 2;
        }

        .product-item {
            border: 1px solid #eee;
            border-radius: 5px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-item .image {
            position: relative;
            overflow: hidden;
        }

        .product-item .image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .product-item:hover .image img {
            transform: scale(1.05);
        }

        .product-item .content {
            padding: 15px;
        }

        .product-item .title a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }

        .product-item .price {
            color: #ff4b4b;
            font-weight: bold;
        }

        .product-item .old {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9em;
            margin-left: 5px;
        }

        .product-item .size span {
            margin-right: 5px;
            color: #666;
        }

        .product-item .ratting i {
            color: #ffc107;
        }

        .color-swatch {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .color-swatch:hover {
            transform: scale(1.2);
        }

        .color-options {
            margin: 8px 0;
            display: flex;
            align-items: center;
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
                        <h1><?php echo htmlspecialchars($page_title); ?></h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href=""><?php echo htmlspecialchars($page_title); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row row-30 mbn-40">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div id="message" class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1050; width: 50%;">
                            <div class="alert alert-danger alert-dismissible fade show text-center shadow-lg" role="alert">
                                <p class="mb-0"><?= htmlspecialchars($_SESSION['error']) ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="col">
                        <div class="row">
                            <!-- Products container -->
                            <div class="col-12" id="products-container">
                                <div class="row" id="products-row">
                                    <!-- Products will be loaded here via AJAX -->
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12" id="pagination-container">
                                        <!-- Pagination will be loaded here via AJAX -->
                                    </div>
                                </div>
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
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="brand-item col"><img src="assets/images/brands/brand-<?= $i ?>.png" alt="Brand <?= $i ?>"></div>
                        <?php endfor; ?>
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
            // Get the type from URL
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type') || 'popular';

            // Load initial products
            loadProducts(type, 1);

            function loadProducts(type, page) {
                $.ajax({
                    url: 'proccess/get_special_products.php',
                    type: 'GET',
                    data: {
                        type: type,
                        page: page,
                        limit: 12
                    },
                    beforeSend: function() {
                        // Show loading spinner and hide any existing products
                        $('.loading-spinner').show();
                        $('#products-row').empty();
                        $('#pagination-container').empty();
                    },
                    success: function(response) {
                        try {
                            if (response.products) {
                                $('#products-row').html(generateProductHTML(response.products));
                            }
                            if (response.pagination) {
                                $('#pagination-container').html(generatePaginationHTML(response.pagination));
                            }
                        } catch (e) {
                            console.error('Error processing response:', e);
                            $('#products-row').html('<div class="col-12 text-center py-5"><p>Error displaying products. Please try again.</p></div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#products-row').html('<div class="col-12 text-center py-5"><p>Error loading products. Please try again.</p></div>');
                    },
                    complete: function() {
                        // Always hide the loading spinner when request is complete
                        $('.loading-spinner').hide();
                    }
                });
            }

            function generateProductHTML(products) {
                if (!products || products.length === 0) {
                    return '<div class="col-12 text-center"><p>No products found.</p></div>';
                }

                let html = '';
                products.forEach(product => {
                    // Convert string prices to numbers
                    const price = parseFloat(product.price) || 0;
                    const newPrice = parseFloat(product.new_price) || 0;

                    let discount_percentage = 0;
                    if (product.on_sale && newPrice < price) {
                        discount_percentage = Math.round(((price - newPrice) / price) * 100);
                    }

                    let colorsHtml = '';
                    if (product.colors) {
                        // Split the comma-separated colors
                        const colorsArray = product.colors.split(',');
                        colorsArray.forEach(color => {
                            // Create a color swatch for each color
                            colorsHtml += `<span class="color-swatch" style="background-color: ${color.trim()};" title="${color.trim()}"></span>`;
                        });
                    }

                    html += `
                <div class="col-xl-4 col-md-6 col-12 mb-40">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="admin-pages/${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}">
                                ${discount_percentage > 0 ? `<span class="label sale-label">${discount_percentage}%</span>` : ''}
                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        <button class="add-to-cart" data-id="${product.product_id}">add to cart</button>
                                        <button>add to wishlist</button>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <div class="content-left">
                                    <h4 class="title"><a href="product-details.php?id=${product.product_id}">${escapeHtml(product.name)}</a></h4>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                    </div>
                                    <div class="color-options">
                                        ${colorsHtml}
                                    </div>
                                    <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                </div>
                                <div class="content-right">
                                    <span class="price">$${newPrice.toFixed(2)} ${price > newPrice ? `<span class="old">$${price.toFixed(2)}</span>` : ''}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                });
                return html;
            }

            function generatePaginationHTML(pagination) {
                const {
                    total_pages,
                    current_page
                } = pagination;
                if (total_pages <= 1) return '';

                let html = '<div class="pagination-wrap"><ul class="pagination">';

                // Previous button
                if (current_page > 1) {
                    html += `<li><a class="page-link" href="#" data-page="${current_page - 1}">Previous</a></li>`;
                }

                // Page numbers
                const start_page = Math.max(1, current_page - 2);
                const end_page = Math.min(total_pages, current_page + 2);

                if (start_page > 1) {
                    html += `<li><a class="page-link" href="#" data-page="1">1</a></li>`;
                    if (start_page > 2) {
                        html += '<li class="disabled"><span>...</span></li>';
                    }
                }

                for (let i = start_page; i <= end_page; i++) {
                    const active = (i == current_page) ? 'active' : '';
                    html += `<li class="${active}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                }

                if (end_page < total_pages) {
                    if (end_page < total_pages - 1) {
                        html += '<li class="disabled"><span>...</span></li>';
                    }
                    html += `<li><a class="page-link" href="#" data-page="${total_pages}">${total_pages}</a></li>`;
                }

                // Next button
                if (current_page < total_pages) {
                    html += `<li><a class="page-link" href="#" data-page="${current_page + 1}">Next</a></li>`;
                }

                html += '</ul></div>';
                return html;
            }

            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Handle pagination clicks
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                const type = urlParams.get('type') || 'popular';
                loadProducts(type, page);

                // Smooth scroll to top of products
                $('html, body').animate({
                    scrollTop: $('#products-container').offset().top - 100
                }, 300);
            });
        });
    </script>
</body>

</html>