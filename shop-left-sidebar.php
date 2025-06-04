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

// Initial values for filters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at DESC';
$tag_filter = isset($_GET['tag']) ? (array)$_GET['tag'] : [];
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
        #products-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Loading spinner style */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner img {
            width: 50px;
        }

        /* Filter dropdown styles */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .filter-dropdown {
            flex: 1 1 150px;
            min-width: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .filter-dropdown select {
            width: 100%;
        }

        /* Hide labels on small screens */
        @media (max-width: 600px) {
            .filter-label {
                display: none;
            }

            .filter-dropdown {
                flex: 1 1 100px;
            }

            .nice-select {
                width: 130px;
                font-size: 10px;
            }
        }


        /* Clear filters button */
        .clear-filters-btn {
            display: inline-block;
            padding: 8px 15px;
            background: #f5f5f5;
            color: #333;
            border-radius: 4px;
            margin-top: 10px;
        }

        .clear-filters-btn:hover {
            background: #eee;
            color: #000;
        }

        .badge {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 20px;
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
                        <h1>Categories</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="">Categories</a></li>
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
                                <p class="mb-0"><?= $_SESSION['error'] ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php unset($_SESSION['error']);
                    endif; ?>


                    <div class="col">
                        <div class="row">
                            <div class="mb-4 col-12 d-flex align-items-center justify-content-between">
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="badge bg-primary text-white">Showing: <?= $limit ?></span>
                                    <span class="badge bg-secondary text-white">Sorted by: <?= ucwords(str_replace(['_', 'DESC', 'ASC'], [' ', '↓', '↑'], $sort)) ?></span>

                                    <?php if (!empty($tag_filter)): ?>
                                        <span class="badge bg-info text-dark">
                                            Category:
                                            <?php
                                            $selectedNames = array_filter($tags, function ($tag) use ($tag_filter) {
                                                return in_array($tag['tag_id'], $tag_filter);
                                            });
                                            echo implode(', ', array_map(fn($t) => $t['name'], $selectedNames));
                                            ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark">Category: All</span>
                                    <?php endif; ?>
                                </div>

                                <!-- filter row -->
                                <div>
                                    <button class="btn btn-outline-primary" id="open-filter-sheet">
                                        <i class="fa fa-filter" aria-hidden="true"></i> Filter
                                    </button>
                                </div>
                            </div>



                            <!-- Products container -->
                            <div class="col-12" id="products-container">
                                <div class="loading-spinner">
                                    <img src="https://loading.io/asset/780798" alt="Loading...">
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
        </div>
        <!-- Brand Section End -->


        <!-- off canvas filter section -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="filterBottomSheet" style="height: 40vh;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Filter Options</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">

                <div class="filter-dropdown">
                    <h4><span class="filter-label">Category:</span></h4>
                    <select class="nice-select" id="category-select" aria-placeholder="choose category" multiple>
                        <option value="" disabled selected hidden>Select an option</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?= $tag['tag_id'] ?>" <?= in_array($tag['tag_id'], $tag_filter) ? 'selected' : '' ?>>
                                <?= $tag['name'] ?> (<?= $tag['product_count'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <h4><span class="filter-label">Show:</span></h4>
                    <select class="nice-select" id="limit-select">
                        <option value="8" <?= $limit == 8 ? 'selected' : '' ?>>8</option>
                        <option value="12" <?= $limit == 12 ? 'selected' : '' ?>>12</option>
                        <option value="16" <?= $limit == 16 ? 'selected' : '' ?>>16</option>
                        <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                    </select>
                </div>

                <div class="filter-dropdown">
                    <h4><span class="filter-label">Sort by:</span></h4>
                    <select class="nice-select" id="sort-select">
                        <option value="created_at DESC" <?= $sort == 'created_at DESC' ? 'selected' : '' ?>>Newest First</option>
                        <option value="created_at ASC" <?= $sort == 'created_at ASC' ? 'selected' : '' ?>>Oldest First</option>
                        <option value="price ASC" <?= $sort == 'price ASC' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price DESC" <?= $sort == 'price DESC' ? 'selected' : '' ?>>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

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

            // Initialize Nice Select for all dropdowns (this is crucial)
            $('#category-select').niceSelect();
            $('#limit-select').niceSelect();
            $('#sort-select').niceSelect();

            // Function to update the display text of the category-select Nice Select
            function updateCategoryNiceSelectDisplay() {
                const $categorySelect = $('#category-select');
                const $niceSelectCurrent = $categorySelect.next('.nice-select').find('.current'); // The visible text span

                let selectedOptionsText = [];
                let hasActualSelection = false;

                $categorySelect.find('option:selected').each(function() {
                    const value = $(this).val();
                    const text = $(this).text().trim();

                    // Exclude the "Select an option" if it's the disabled, hidden one
                    if (value !== "" && !$(this).is(':disabled') && !$(this).is(':hidden')) {
                        selectedOptionsText.push(text.replace(/\s*\(\d+\)\s*$/, '')); // Remove (count) from the display
                        hasActualSelection = true;
                    }
                });

                if (selectedOptionsText.length === 0) {
                    // If no actual tags are selected, show "Select an option"
                    $niceSelectCurrent.text('Select an option');
                } else {
                    // If tags are selected, display them comma-separated
                    $niceSelectCurrent.text(selectedOptionsText.join(', '));
                }

                // If "Select an option" was selected initially and no tags are active
                // Ensure it's not shown if other options are selected.
                // This part might need fine-tuning based on Nice Select's exact default behavior.
                // For a multi-select, the 'Select an option' typically only appears if nothing is truly selected.
                // If it's still causing issues, you might remove the 'selected' from it in PHP if tag_filter is not empty.
            }

            // Function to load products via AJAX
            function loadProducts() {
                const formData = new FormData();

                // Get current page from URL or default to 1
                const currentPage = new URLSearchParams(window.location.search).get('page') || '1';
                formData.append('page', currentPage);

                // Get filter values from dropdowns
                const currentLimit = $('#limit-select').val();
                const currentSort = $('#sort-select').val();
                const selectedTags = [];

                formData.append('limit', currentLimit);
                formData.append('sort', currentSort);

                $('#category-select option:selected').each(function() {
                    const val = $(this).val();
                    if (val !== "") { // Ensure we only append actual tag values
                        formData.append('tag[]', val);
                        selectedTags.push({
                            id: val,
                            name: $(this).text().split(' (')[0]
                        }); // Store tag ID and name
                    }
                });

                // Convert FormData to URLSearchParams
                const urlParams = new URLSearchParams();
                for (const pair of formData.entries()) {
                    // For multiple 'tag[]' parameters, URLSearchParams.append handles it correctly
                    urlParams.append(pair[0], pair[1]);
                }

                // Show loading spinner
                $('#products-row').hide();
                $('.loading-spinner').show();
                $('#pagination-container').empty(); // Clear pagination during load

                $.ajax({
                    url: 'proccess/ajax_filter.php?' + urlParams.toString(),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Update URL without reloading
                        const newUrl = window.location.pathname + '?' + urlParams.toString();
                        window.history.pushState({
                            path: newUrl
                        }, '', newUrl);

                        // --- START OF BADGE UPDATE ---
                        // Update 'Showing' badge
                        $('.badge.bg-primary').text(`Showing: ${currentLimit}`);

                        // Update 'Sorted by' badge
                        let sortText = currentSort.replace(/_/g, ' '); // Replace underscores with spaces
                        if (sortText.includes('DESC')) {
                            sortText = sortText.replace('DESC', '↓');
                        } else if (sortText.includes('ASC')) {
                            sortText = sortText.replace('ASC', '↑');
                        }
                        $('.badge.bg-secondary').text(`Sorted by: ${sortText}`);

                        // Update 'Category' badge
                        const categoryBadge = $('.badge.bg-info');
                        const defaultCategoryBadge = $('.badge.bg-light'); // The 'Category: All' badge

                        if (selectedTags.length > 0) {
                            const tagNames = selectedTags.map(tag => tag.name).join(', ');
                            categoryBadge.removeClass('bg-light text-dark').addClass('bg-info text-dark').text(`Category: ${tagNames}`).show();
                            defaultCategoryBadge.hide(); // Hide the 'Category: All' badge
                        } else {
                            // If no tags selected, show 'Category: All' badge and hide info badge
                            defaultCategoryBadge.removeClass('bg-info text-dark').addClass('bg-light text-dark').text('Category: All').show();
                            categoryBadge.hide();
                        }
                        // --- END OF BADGE UPDATE ---

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

            // Function to render products (your existing function, no changes needed)
            function renderProducts(products) {
                let html = '';

                if (products.length === 0) {
                    html = '<div class="col-12 text-center"><p>No products found matching your criteria.</p></div>';
                } else {
                    products.forEach(product => {
                        let colorsHtml = '';
                        if (product.colors && product.colors.length > 0) {
                            product.colors.forEach(color => {
                                colorsHtml += `<span style="background-color: ${color}; width: 15px; height: 15px; display: inline-block; border-radius: 50%; margin-right: 5px; border: 1px solid #ddd;"></span>`;
                            });
                        }

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
                                <h5 class="color">Colors: ${colorsHtml}</h5>
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

            // Function to render pagination (your existing function, no changes needed)
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

            // Initial load of products and update of display text
            loadProducts();
            updateCategoryNiceSelectDisplay(); // Call this immediately after Nice Select initializes

            // Handle filter changes
            $('#limit-select, #sort-select, #category-select').change(function() {
                // Reset page to 1 when filters change
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', '1');
                window.history.pushState({
                    path: window.location.pathname + '?' + urlParams.toString()
                }, '', window.location.pathname + '?' + urlParams.toString());

                loadProducts();
                updateCategoryNiceSelectDisplay(); // Update display after selecting categories
            });


            // Handle pagination clicks
            $(document).on('click', '.page-pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', page);

                // Update URL
                window.history.pushState({}, '', '?' + urlParams.toString());

                // Load products for the new page
                $.ajax({
                    url: 'proccess/ajax_filter.php?' + urlParams.toString(),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        renderProducts(response.products);
                        renderPagination(response.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Handle message dismissal
            setTimeout(function() {
                $('#message').fadeOut('slow');
            }, 5000); // Message disappears after 5 seconds

            document.getElementById('open-filter-sheet').addEventListener('click', function() {
                const filterSheet = new bootstrap.Offcanvas(document.getElementById('filterBottomSheet'));
                filterSheet.show();
            });
        });
    </script>

</body>

</html>