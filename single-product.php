<?php
session_start();
include 'classes/database.php';
include 'classes/product.php';
include 'classes/cart.php';
include 'classes/wishlist.php';

if (isset($_GET['product_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $product->product_id = $_GET['product_id'];
    $prod = $product->getById();
    $prodSizesAndColors = $product->getSizesAndColors();
    $prodTags = $product->getTags();
    $relatedProducts = $product->getRelatedProducts();
    $wishlist = new Wishlist($db);
    // check if prouct is in wishlisht
    $wishlist->product_id = $_GET['product_id'];
    $isInWishlist = $wishlist->isProductInWishlist();
    $tags = $product->getTags();

    // Fetch stock data for each size and color combination
    $stockData = [];
    foreach ($prodSizesAndColors as $item) {
        $stock = $product->getStockForSizeAndColor($item['size'], $item['color']);
        $stockData[$item['color']][$item['size']] = $stock;
    }

    // Fetch cart quantities for the product, size, and color
    $cartQuantities = [];
    if (isset($_SESSION['customer_id'])) {
        $cart = new Cart($db);
        $cart->customer_id = $_SESSION['customer_id'];
        foreach ($prodSizesAndColors as $item) {
            $cartQuantity = $cart->getCartQuantityForProduct($prod['product_id'], $item['size'], $item['color']);
            $cartQuantities[$item['color']][$item['size']] = $cartQuantity;
        }
    }
} else {
    // Redirect if no product ID is provided
    header('Location: index.php');
    exit();
}

session_abort();
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

    <!-- Other meta tags -->
    <meta property="og:title" content="<?= $prod['name'] ?>" />
    <meta property="og:description" content="<?= $prod['description'] ?>" />
    <meta property="og:image" content="http://<?= $_SERVER['HTTP_HOST'] ?>/admin-pages/<?= $prod['image'] ?>" />
    <meta property="og:url" content="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" />
    <meta property="og:type" content="product" />

    <!-- CSS
 ============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/icon-font.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>

    <style>
        #stock-display {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }

        #stock-display p {
            margin: 5px 0;
        }

        .wishlist-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .wishlist-btn i {
            color: #333;
            transition: all 0.3s ease;
        }

        .wishlist-btn.active i,
        .wishlist-btn:hover i {
            color: #FF7891;
        }

        .wishlist-btn:focus {
            outline: none;
        }

        /* Add these new styles */
        .out-of-stock {
            color: red !important;
        }

        .not-available {
            color: red !important;
        }

        .disabled-button {
            background-color: #cccccc !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <?php include 'header.php'; ?>

        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(admin-pages/<?= $prod['image'] ?>)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1><?= $prod['name'] ?></h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="single-product.html"><?= $prod['name'] ?></a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row row-30 mbn-50">

                    <div class="col-12">
                        <div class="row row-20 mb-10">

                            <div class="col-lg-6 col-12 mb-40">
                                <!-- Main Image Container -->
                                <div class="pro-large-img easyzoom easyzoom--with-thumbnails">
                                    <a href="admin-pages/<?= $prodSizesAndColors[0]['color_image'] ?>">
                                        <img src="admin-pages/<?= $prod['image'] ?>" alt="" />
                                    </a>
                                </div>

                                <!-- Thumbnail Slider -->
                                <ul id="pro-thumb-img" class="pro-thumb-img">
                                    <?php foreach ($prodSizesAndColors as $prodSizeAndColor): ?>
                                        <li>
                                            <a href="#" data-standard="admin-pages/<?= $prodSizeAndColor['color_image'] ?>" data-color="<?= $prodSizeAndColor['color'] ?>">
                                                <img data-color="<?= $prodSizeAndColor['color'] ?>" src="admin-pages/<?= $prodSizeAndColor['color_image'] ?>" alt="" />
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="col-lg-6 col-12 mb-40">
                                <div class="single-product-content">

                                    <div class="head">
                                        <div class="head-left">

                                            <h3 class="title"><?= $prod['name'] ?></h3>

                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>

                                        </div>

                                        <div class="head-right">
                                            <span class="price">
                                                <div class="content-right">
                                                    <?php if ($prod['new_price'] > 0): ?>
                                                        <span class="price" style="color: #FF708A;">$<?= number_format($prod['new_price'], 2) ?></span>
                                                        <span class="old-price" style="color: #94C7EB; text-decoration: line-through;">
                                                            $<?= number_format($prod['price'], 2) ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="price">$<?= number_format($prod['price'], 2) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="description">
                                        <?= $prod['description'] ?>
                                    </div>

                                    <div class="tags">
                                        <div class="tags" style="margin-bottom: 5px;">
                                            <?php foreach ($tags as $tag): ?>
                                                <span class="product-tag" style="background-color: #94c7eb; padding: 2px 5px; border-radius: 3px; font-size: 12px; margin-right: 5px;">
                                                    <a href="shop-left-sidebar.php?tag=<?= $tag['tag_id'] ?>"><?= $tag['name'] ?></a>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <span class="availability">Availability:
                                        <span id="availability-status">
                                            <?php
                                            $totalStock = 0;
                                            foreach ($stockData as $color => $sizes) {
                                                foreach ($sizes as $size => $stock) {
                                                    $totalStock += $stock;
                                                }
                                            }
                                            echo ($totalStock > 0) ? 'In Stock' : 'Out of Stock';
                                            ?>
                                        </span>
                                    </span>

                                    <div class="quantity-colors">
                                        <div class="quantity">
                                            <h5>Quantity:</h5>
                                            <div class="pro-qty"><input type="text" id="quantity-input" value="1"></div>
                                        </div>

                                        <div class="colors">
                                            <h5>Color:</h5>
                                            <div class="color-options">
                                                <?php $uniqueColors = array_unique(array_column($prodSizesAndColors, 'color'));
                                                foreach ($uniqueColors as $color): ?>
                                                    <button style="background-color: <?= $color ?>" data-color="<?= $color ?>" <?php if ($color === reset($uniqueColors)) {
                                                                                                                                    echo 'class="active"';
                                                                                                                                } ?>>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div class="sizes">
                                            <h5>Size:</h5>
                                            <div class="size-options">
                                                <?php
                                                $sizes = array_unique(array_column($prodSizesAndColors, 'size'));
                                                foreach ($sizes as $key => $size): ?>
                                                    <button value="<?= htmlspecialchars($size) ?>" data-size="<?= htmlspecialchars($size) ?>" <?php if ($key === 0) {
                                                                                                                                                    echo 'class="active"';
                                                                                                                                                } ?>><?= htmlspecialchars($size) ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <table id="stock-display" class="table table-bordered">

                                        </table>
                                    </div>

                                    <div class="actions">
                                        <button id="add-to-cart-button" <?php echo ($totalStock <= 0) ? 'disabled class="disabled-button"' : ''; ?>>
                                            <i class="ti-shopping-cart"></i><span><?php echo ($totalStock <= 0) ? 'OUT OF STOCK' : 'ADD TO CART'; ?></span>
                                        </button>
                                        <button class="box" data-tooltip="Compare"><i class="ti-control-shuffle"></i></button>
                                        <button class="wishlist-btn box" data-product-id="<?= $prod['product_id'] ?>"><i class="ti-heart"></i></button>
                                    </div>

                                    <div class="tags">

                                        <h5>Tags:</h5>
                                        <?php foreach ($prodTags as $prodTag): ?>
                                            <a href="#"><?= $prodTag['name'] ?></a>
                                        <?php endforeach; ?>

                                    </div>

                                    <div class="share">

                                        <h5>Share: </h5>
                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                            target="_blank"><i class="fa fa-facebook"></i></a>
                                        <!-- Instagram -->
                                        <a href="https://www.instagram.com/" target="_blank"><i
                                                class="fa fa-instagram"></i></a>
                                        <!-- Twitter (Optional) -->
                                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=Check%20out%20this%20product:%20<?= urlencode($prod['name']) ?>"
                                            target="_blank"><i class="fa fa-twitter"></i></a>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-50">
                            <!-- Nav tabs -->
                            <div class="col-12">
                                <ul class="pro-info-tab-list section nav">
                                    <li><a class="active" href="#more-info" data-bs-toggle="tab">More info</a></li>
                                    <li><a href="#data-sheet" data-bs-toggle="tab">Data sheet</a></li>
                                    <li><a href="#reviews" data-bs-toggle="tab">Reviews</a></li>
                                </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content col-12">
                                <div class="pro-info-tab tab-pane active" id="more-info">
                                    <p>Fashion has been creating well-designed collections since 2010. The brand offers
                                        feminine designs delivering stylish separates and statement dresses which have
                                        since evolved into a full ready-to-wear collection in which every item is a
                                        vital part of a woman's wardrobe. The result? Cool, easy, chic looks with
                                        youthful elegance and unmistakable signature style. All the beautiful pieces are
                                        made in Italy and manufactured with the greatest attention. Now Fashion extends
                                        to a range of accessories including shoes, hats, belts and more!</p>
                                </div>
                                <div class="pro-info-tab tab-pane" id="data-sheet">
                                    <table class="table-data-sheet">
                                        <tbody>
                                            <tr class="odd">
                                                <td>Compositions</td>
                                                <td>Cotton</td>
                                            </tr>
                                            <tr class="even">
                                                <td>Styles</td>
                                                <td>Casual</td>
                                            </tr>
                                            <tr class="odd">
                                                <td>Properties</td>
                                                <td>Short Sleeve</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pro-info-tab tab-pane" id="reviews">
                                    <a href="#">Be the first to write your review!</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div><!-- Page Section End -->

        <!-- Related Product Section Start -->
        <div class="section section-padding pt-0">
            <div class="container">

                <div class="section-title text-start mb-30">
                    <h1>Related Product</h1>
                </div>

                <div class="related-product-slider related-product-slider-1 slick-space p-0">

                    <?php foreach ($relatedProducts as $relatedProduct):
                        // Fetch sizes and colors for the related product
                        $relatedProductSizesAndColors = $product->getSizesAndColorsForProduct($relatedProduct['product_id']);
                        $uniqueSizes = array_unique(array_column($relatedProductSizesAndColors, 'size'));
                        $uniqueColors = array_unique(array_column($relatedProductSizesAndColors, 'color'));
                    ?>
                        <div class="slick-slide">

                            <div class="product-item">
                                <div class="product-inner">

                                    <div class="image">
                                        <img src="admin-pages/<?= $relatedProduct['image'] ?>" alt="">

                                        <div class="image-overlay">
                                            <div class="action-buttons">
                                                <button><a href="single-product.php?product_id=<?= $relatedProduct['product_id'] ?>">Add To Cart</a></button>
                                                <button class="wishlist-btn" data-product-id="<?= $relatedProduct['product_id'] ?>">Add to Wishlist</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="content">

                                        <div class="content-left">

                                            <h4 class="title"><a href="single-product.php?product_id=<?= $relatedProduct['product_id'] ?>"><?= $relatedProduct['name'] ?></a></h4>

                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>

                                            <h5 class="size">Size:
                                                <?php foreach ($uniqueSizes as $size): ?>
                                                    <span><?= htmlspecialchars($size) ?></span>
                                                <?php endforeach; ?>
                                            </h5>
                                            <h5 class="color">Color:
                                                <?php foreach ($uniqueColors as $color): ?>
                                                    <span style="background-color: <?= $color ?>"></span>
                                                <?php endforeach; ?>
                                            </h5>

                                        </div>

                                        <div class="content-right">
                                            <span class="price">$<?= $relatedProduct['price'] ?></span>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div><!-- Related Product Section End -->

        <!-- Brand Section Start -->
        <div class="brand-section section section-padding pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="brand-slider">

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-1.png" alt="">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-2.png" alt="">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-3.png" alt="">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-4.png" alt="">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-5.png" alt="">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-6.png" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- Brand Section End -->

        <?php include 'footer.php' ?>

    </div>

    <!-- JS
============================================ -->

    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Migrate JS -->
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins JS -->
    <script src="assets/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedColor = document.querySelector('.color-options button').getAttribute('data-color');
            let selectedSize = document.querySelector('.size-options button').getAttribute('data-size');
            let stockData = <?php echo json_encode($stockData); ?>;
            let cartQuantities = <?php echo json_encode($cartQuantities); ?>;

            function updateStockDisplay() {
                if (stockData[selectedColor] && stockData[selectedColor][selectedSize] !== undefined) {
                    let availableStock = stockData[selectedColor][selectedSize];
                    let cartQuantity = cartQuantities[selectedColor] && cartQuantities[selectedColor][selectedSize] ? cartQuantities[selectedColor][selectedSize] : 0;
                    let remainingStock = availableStock - cartQuantity;

                    document.getElementById('stock-display').innerHTML = `
                        <tr>
                            <td>Total Stock:</td>
                            <td>In Cart:</td>
                            <td>Remaining Stock:</td>
                        </tr>
                        <tr>
                            <td><span id="total-stock">${availableStock}</span></td>
                            <td><span id="in-cart">${cartQuantity}</span></td>
                            <td><span id="remaining-stock">${remainingStock}</span></td>
                        </tr>
                    `;

                    // Ensure quantity input respects remaining stock
                    let quantityInput = document.getElementById('quantity-input');
                    quantityInput.max = remainingStock;
                    if (parseInt(quantityInput.value) > remainingStock) {
                        quantityInput.value = remainingStock;
                    }
                } else {
                    document.getElementById('stock-display').innerHTML = `
                        <tr>
                            <td colspan="3" style="color: red; text-align: center;">Not Available</td>
                        </tr>
                    `;
                    document.getElementById('quantity-input').value = 1;
                    document.getElementById('quantity-input').max = 0;
                }
            }

            updateStockDisplay();

            // Event listeners for color and size selection
            document.querySelectorAll('.color-options button').forEach(button => {
                button.addEventListener('click', function() {
                    selectedColor = this.getAttribute('data-color');
                    updateStockDisplay();
                });
            });

            document.querySelectorAll('.size-options button').forEach(button => {
                button.addEventListener('click', function() {
                    selectedSize = this.getAttribute('data-size');
                    updateStockDisplay();
                });
            });

            document.querySelectorAll('.pro-thumb-img img').forEach(img => {
                img.addEventListener('click', function() {
                    selectedColor = this.getAttribute('data-color');
                    updateStockDisplay();
                });
            });

            // Ensure quantity input doesn't exceed stock
            document.getElementById('quantity-input').addEventListener('input', function() {
                let maxStock = parseInt(this.max, 10) || Infinity;
                let newValue = parseInt(this.value, 10) || 1;

                if (newValue > maxStock) {
                    this.value = maxStock;
                } else if (newValue < 1) {
                    this.value = 1;
                }
            });

            // Handle add to cart button click
            document.getElementById('add-to-cart-button').addEventListener('click', function() {
                const productId = <?= $prod['product_id'] ?>;
                const quantity = parseInt(document.getElementById('quantity-input').value, 10);
                const color = selectedColor;
                const size = selectedSize;

                fetch('proccess/add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity,
                            color: color,
                            size: size
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success && data.redirect) {
                            window.location.href = data.redirect;
                        } else if (data.success) {
                            showSuccessMessage("Product added to cart successfully!");
                            setTimeout(() => window.location.reload(), 2000);
                        } else {
                            alert('Failed to add product to cart: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding the product to the cart. Please try again.');
                    });
            });

            function showSuccessMessage(message) {
                let alertContainer = document.createElement("div");
                let timerContainer = document.createElement("span");
                let timer = 2; // 5 seconds countdown timer

                alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                document.body.appendChild(alertContainer);


            }

        });

        $(document).ready(function() {
            $(".wishlist-btn").click(function(e) {
                e.preventDefault();
                var productId = $(this).data("product-id");
                var button = $(this);
                var icon = button.find('i');

                $.ajax({
                    url: "proccess/add_to_wishlist.php",
                    type: "POST",
                    data: {
                        product_id: productId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // Toggle active class and change icon color
                            button.toggleClass("active");
                            if (button.hasClass("active")) {
                                icon.css("color", "#ff0000"); // Red color for active
                            } else {
                                icon.css("color", ""); // Default color
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Something went wrong. Please try again.");
                    }
                });
            });
        });
    </script>


</body>

</html>

</html>