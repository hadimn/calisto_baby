<?php
include 'classes/database.php';
include 'classes/product.php';
include 'classes/cart.php';

if (isset($_GET['product_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $product->product_id = $_GET['product_id'];
    $prod = $product->getById();
    $prodSizesAndColors = $product->getSizesAndColors();
    $prodTags = $product->getTags();
    $relatedProducts = $product->getRelatedProducts();

    $stockData = [];
    foreach ($prodSizesAndColors as $item) {
        $stock = $product->getStockForSizeAndColor($item['size'], $item['color']);
        $stockData[$item['color']][$item['size']] = $stock;
    }
}
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
                                <div class="pro-large-img mb-10 fix easyzoom easyzoom--with-thumbnails d-flex justify-content-center align-items-center" style="width: 400px; height: 400px; margin: 0 auto;">
                                    <a href="admin-pages/<?= $prodSizesAndColors[0]['color_image'] ?>">
                                        <img src="admin-pages/<?= $prod['image'] ?>" alt="" class="img-fluid main-image object-fit-contain" style="max-width: 100%; max-height: 100%;" />
                                    </a>
                                </div>

                                <!-- Thumbnail Slider -->
                                <ul id="pro-thumb-img" class="pro-thumb-img list-unstyled d-flex gap-2 overflow-auto">
                                    <?php foreach ($prodSizesAndColors as $prodSizeAndColor): ?>
                                        <li class="flex-shrink-0">
                                            <a href="#" data-standard="admin-pages/<?= $prodSizeAndColor['color_image'] ?>" data-color="<?= $prodSizeAndColor['color'] ?>">
                                                <img src="admin-pages/<?= $prodSizeAndColor['color_image'] ?>" alt="" class="img-thumbnail object-fit-cover" style="width: 200px; height: 80px;" />
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
                                            <span class="price">$25</span>
                                        </div>
                                    </div>

                                    <div class="description">
                                        <?= $prod['description'] ?>
                                    </div>

                                    <span class="availability">Availability: <span>In Stock</span></span>

                                    <div class="quantity-colors">
                                        <div class="quantity hidden">
                                            <h5>Quantity:</h5>
                                            <div class="pro-qty"><input type="text" id="quantity-input" value="1"></div>
                                        </div>

                                        <div class="colors">
                                            <h5>Color:</h5>
                                            <div class="color-options">
                                                <?php foreach ($prodSizesAndColors as $prodSizeAndColor): ?>
                                                    <button style="background-color: <?= $prodSizeAndColor['color'] ?>" data-color="<?= $prodSizeAndColor['color'] ?>"></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div class="sizes">
                                            <h5>Size:</h5>
                                            <div class="size-options">
                                                <?php
                                                $sizes = array_unique(array_column($prodSizesAndColors, 'size'));
                                                foreach ($sizes as $size): ?>
                                                    <button value="<?= htmlspecialchars($size) ?>" data-size="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div id="stock-display"></div>
                                    </div>

                                    <div class="actions">
                                        <button id="add-to-cart-button"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></button>
                                        <button class="box" data-tooltip="Compare"><i class="ti-control-shuffle"></i></button>
                                        <button class="box" data-tooltip="Wishlist"><i class="ti-heart"></i></button>
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

                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="slick-slide">

                            <div class="product-item">
                                <div class="product-inner">

                                    <div class="image">
                                        <img src="admin-pages/<?= $relatedProduct['image'] ?>" alt="">

                                        <div class="image-overlay">
                                            <div class="action-buttons">
                                                <button>add to cart</button>
                                                <button>add to wishlist</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="content">

                                        <div class="content-left">

                                            <h4 class="title"><a href="single-product.html">Tmart Baby Dress</a></h4>

                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>

                                            <h5 class="size">Size:
                                                <span>S</span><span>M</span><span>L</span><span>XL</span>
                                            </h5>
                                            <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span
                                                    style="background-color: #0271bc"></span><span
                                                    style="background-color: #efc87c"></span><span
                                                    style="background-color: #00c183"></span></h5>

                                        </div>

                                        <div class="content-right">
                                            <span class="price">$25</span>
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
            // Initialize selected values
            let selectedColor = document.querySelector('.color-options button').getAttribute('data-color');
            let selectedSize = document.querySelector('.size-options button').getAttribute('data-size');
            let selectedQuantity = document.getElementById('quantity-input').value;

            // Get stock data from PHP
            let stockData = <?php echo json_encode($stockData); ?>;

            // Function to update the stock display
            function updateStockDisplay() {
                if (stockData[selectedColor] && stockData[selectedColor][selectedSize] !== undefined) {
                    let availableStock = stockData[selectedColor][selectedSize];
                    document.getElementById('stock-display').textContent = 'Stock: ' + availableStock;
                    document.getElementById('quantity-input').max = availableStock;
                    if (parseInt(document.getElementById('quantity-input').value) > availableStock) {
                        document.getElementById('quantity-input').value = availableStock;
                        selectedQuantity = availableStock;
                    }
                } else {
                    document.getElementById('stock-display').textContent = 'Stock: Not available';
                    document.getElementById('quantity-input').max = 0;
                    document.getElementById('quantity-input').value = 1;
                    selectedQuantity = 1;
                }
            }

            // Initial stock display update
            updateStockDisplay();

            // Update selected color and stock when a color button is clicked
            document.querySelectorAll('.color-options button').forEach(button => {
                button.addEventListener('click', function() {
                    selectedColor = this.getAttribute('data-color');
                    updateStockDisplay();
                });
            });

            // Update selected size and stock when a size button is clicked
            document.querySelectorAll('.size-options button').forEach(button => {
                button.addEventListener('click', function() {
                    selectedSize = this.getAttribute('data-size');
                    updateStockDisplay();
                });
            });

            // Update selected quantity when the quantity input changes
            document.getElementById('quantity-input').addEventListener('change', function() {
                selectedQuantity = this.value;
            });

            // Handle the add to cart button click
            document.getElementById('add-to-cart-button').addEventListener('click', function() {
                const productId = <?= $prod['product_id'] ?>; // Get the product ID from PHP

                // Send the data via AJAX
                fetch('proccess/add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: selectedQuantity,
                            color: selectedColor,
                            size: selectedSize
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = 'cart.php'; // Redirect to cart page
                        } else {
                            alert('Failed to add product to cart: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>


</body>

</html>

</html>