<?php
require_once "classes/database.php";
include_once "classes/product.php";
include_once "classes/cart.php";
include_once "classes/tag.php";

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$tag = new Tag($db);

$latest_tags = $tag->getAll();
// on sale products
$productsOnSale = $product->getPorductsOnSale();
// last three products
$productLastthree = $product->getLastByLimit(3);
// popular products
$popular_products = $product->getPorductsPopular();
// best_deal products
$best_deal_products = $product->getPorductsBestDeal();
// bab new toys tag id
$babyNewToys_tagId = $tag->getNewBabyToysTag()['tag_id'] ?? "12";
// must have basics tag id
$MustHaveBasics_tagId = $tag->getMustHaveBasicsTag()['tag_id'] ?? "34";
// baby items tag id
$babyItems_tagId = $tag->getBabyItemsTag()['tag_id'] ?? "43";

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
        .floating-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            /* Ensure it's above other elements */
            width: 80%;
            /* Adjust width as needed */
            max-width: 500px;
            /* Limit maximum width */
        }

        .see-more-btn {
            display: inline-block;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s;
            color: black;
        }



        .arrow {
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <?php include 'header.php' ?>

        <!-- Hero Section Start "last 4 on-sale products" -->
        <div class="hero-section section">

            <div class="container">
                <?php

                if (isset($_SESSION['error'])) {
                    echo '<div style="width: fit-content;" class="alert alert-danger alert-dismissible fade show floating-alert" role="alert" id="floatingAlert">';
                    echo '  ' . $_SESSION['error'];
                    echo '</div>';
                    unset($_SESSION['error']);
                }
                ?>
            </div>

            <!-- Hero Slider Start -->
            <div class="hero-slider hero-slider-one fix">

                <?php foreach ($latest_tags as $latest_tag): ?>
                    <!-- Hero Item Start -->
                    <div class="hero-item" style="background-image: url(admin-pages/<?= $latest_tag['image'] ?>); background-size: cover">

                        <!-- Hero Content -->
                        <div class="hero-content border">
                            <h1><?= $latest_tag['name'] ?> <br><?php echo htmlspecialchars(substr($latest_tag['description'], 0, 50)); ?>...</h1>
                            <a href="shop-left-sidebar.php?tag=<?= $latest_tag['tag_id'] ?>">SHOP NOW</a>
                        </div>

                    </div><!-- Hero Item End -->
                <?php endforeach; ?>

            </div><!-- Hero Slider End -->

        </div><!-- Hero Section End -->

        <!-- Banner Section Start -->
        <div class="banner-section section mt-40">
            <div class="container-fluid">
                <div class="row row-10 mbn-20">

                    <div class="col-lg-4 col-md-6 col-12 mb-20">
                        <div class="banner banner-1 content-left content-middle">

                            <a href="shop-left-sidebar.php?tag=<?= $babyItems_tagId ?>" class="image"><img src="assets/images/feature/newArrival.jpg" alt="Banner Image"></a>

                            <div class="content">
                                <h1 style="color: #FF7790;">New Arrival <br>Baby’s items <br>GET ALL YOU WANT</h1>
                                <a href="shop-left-sidebar.php?tag=<?= $babyItems_tagId ?>" data-hover="SHOP NOW">SHOP NOW</a>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-20">
                        <a href="shop-left-sidebar.php?tag=<?= $babyNewToys_tagId ?>" class="banner banner-2">

                            <img src="assets/images/feature/newBorn.jpg" alt="Banner Image">

                            <div class="content bg-theme-one">
                                <h1>New Baby Toy’s</h1>
                            </div>

                            <!-- <span class="banner-offer">25% off</span> -->

                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-20">
                        <div class="banner banner-1 content-left content-top">

                            <a href="shop-left-sidebar.php?tag=<?= $MustHaveBasics_tagId ?>" class="image"><img src="assets/images/feature/mustHave.jpg" alt="Banner Image"></a>

                            <div class="content">
                                <h1 style="color: #FF7790;">Must <br>Have Basics <br> products</h1>
                                <a href="shop-left-sidebar.php?tag=<?= $MustHaveBasics_tagId ?>" data-hover="SHOP NOW">SHOP NOW</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Banner Section End -->

        <!-- popular products -->
        <!-- Product Section Start -->
        <div class="product-section section section-padding">
            <div class="container">

                <div class="row border-bottom mb-2">
                    <div class="section-title text-center col mb-30 d-flex justify-content-between align-items-center">
                        <div>
                            <h1>Popular Products</h1>
                            <p>All popular product find here</p>
                        </div>
                        <a href="special-product.php?type=popular" class="see-more-btn">
                            See More <span class="arrow">→</span>
                        </a>
                    </div>
                </div>

                <div class="row mbn-40">
                    <?php foreach ($popular_products as $popular_product): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40">
                            <div class="product-item">
                                <div class="product-inner">

                                    <div class="image">
                                        <img src="admin-pages/<?= $popular_product['image'] ?>" alt="Image">

                                        <div class="image-overlay">
                                            <div class="action-buttons">
                                                <button><a href="single-product.php?product_id=<?= $popular_product['product_id'] ?>">Add To Cart</a></button>
                                                <button class="wishlist-btn" data-product-id="<?= $popular_product['product_id'] ?>">Add to Wishlist</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="content">

                                        <div class="content-left">

                                            <h4 class="title"><a href="single-product.php?product_id=<?= $popular_product['product_id'] ?>"><?= $popular_product['name'] ?></a></h4>

                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>

                                            <?php
                                            $sizes = $product->getAvailableSizesById($popular_product['product_id']);
                                            $colors = $product->getAvailableColorsById($popular_product["product_id"]);
                                            ?>
                                            <h5 class="size">Size:
                                                <?php foreach ($sizes as $size): ?>
                                                    <span><?= $size ?></span>
                                                <?php endforeach; ?>
                                            </h5>

                                            <h5 class="color">
                                                Color:
                                                <?php foreach ($colors as $color): ?>
                                                    <span style="background-color: <?= $color ?>"></span>
                                                <?php endforeach; ?>
                                            </h5>

                                        </div>

                                        <div class="content-right">
                                            <span class="price">$<?= explode(".", $popular_product['new_price'])[0] ?><?php if (explode(".", $popular_product['price'])[1] != "00") {
                                                                                                                            echo ("." . explode(".", $popular_product['price'])[1]);
                                                                                                                        } ?></span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
        <!-- popular Product Section End -->

        <!-- Banner Section Start -->
        <div class="banner-section section section-padding pt-0 fix">
            <div class="row row-5 mbn-30"> <!-- Changed from mbn-10 to mbn-30 for more space -->

                <!-- Banner 1 - Boy Clothing -->
                <div class="col-lg-4 col-md-6 col-12 mb-30"> <!-- Changed mb-10 to mb-30 -->
                    <div class="banner banner-3">
                        <a href="#" class="image">
                            <img src="assets/images/feature/boyClothes.jpg" alt="Boy Clothing" class="banner-img">
                        </a>

                        <div class="content" style="background-image: url(assets/images/banner/banner-3-shape.png)">
                            <h1>Boy Clothing</h1>
                            <h2>Calisto</h2>
                            <h4>2 - 5 Years</h4>
                        </div>

                        <a href="#" class="shop-link" data-hover="SHOP NOW">SHOP NOW</a>
                    </div>
                </div>

                <!-- Banner 2 - Accessories -->
                <div class="col-lg-4 col-md-6 col-12 mb-30"> <!-- Changed mb-10 to mb-30 -->
                    <div class="banner banner-4">
                        <a href="#" class="image">
                            <img src="assets/images/feature/accessoriesMore.jpg" alt="Accessories" class="banner-img">
                        </a>

                        <div class="content">
                            <div class="content-inner">
                                <h1>Accessories & More</h1>
                                <h2>Adorable Picks <br>New Trend for <?= date("Y") ?></h2>
                                <a href="#" class="shop-link" data-hover="SHOP NOW">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner 3 - Girl Clothing -->
                <div class="col-lg-4 col-md-6 col-12 mb-30"> <!-- Changed mb-10 to mb-30 -->
                    <div class="banner banner-5">
                        <a href="#" class="image">
                            <img src="assets/images/feature/girlClothes.jpg" alt="Girl Clothing" class="banner-img">
                        </a>

                        <div class="content" style="background-image: url(assets/images/banner/banner-5-shape.png)">
                            <h1>Girls Clothing <br>Baby Girl's</h1>
                            <h2>Trendy Styles</h2>
                        </div>

                        <a href="#" class="shop-link" data-hover="SHOP NOW">SHOP NOW</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- Banner Section End -->

        <!-- best deal section -->
        <!-- Product Section Start -->
        <div class="product-section section section-padding pt-0">
            <div class="container">
                <div class="row mbn-40">

                    <div class="col-lg-4 col-md-6 col-12 mb-40">

                        <div class="row border-bottom mb-2">
                            <div class="section-title text-start col mb-30 d-flex justify-content-between align-items-center">
                                <div>
                                    <h1>Best Deal</h1>
                                    <p>Exclusive deals for you</p>
                                </div>
                                <a href="special-product.php?type=best-deal" class="see-more-btn">
                                    See More <span class="arrow">→</span>
                                </a>
                            </div>
                        </div>

                        <div class="best-deal-slider w-100">

                            <?php foreach ($best_deal_products as $best_deal_product): ?>
                                <div class="slide-item">

                                    <div class="best-deal-product">

                                        <div class="image"><img src="admin-pages/<?= $best_deal_product['image'] ?>" class="deal-image" alt="Image"></div>

                                        <div class="content-top">

                                            <div class="content-top-left" style="width: 50%;">
                                                <h4 class="title"><a href="single-product.php?product_id=<?= $best_deal_product['product_id'] ?>"><?= $best_deal_product['name'] ?></a></h4>
                                                <div class="ratting">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-half-o"></i>
                                                </div>
                                            </div>

                                            <div class="content-top-right" style="width: 50%;">
                                                <span class="price">$<?= explode('.', $best_deal_product['new_price'])[0] ?><?php if (explode(".", $best_deal_product['new_price'])[1] != "00") {
                                                                                                                                echo ("." . explode(".", $best_deal_product['new_price'])[1]);
                                                                                                                            } ?>
                                                    <span class="old">$<?= explode(".", $best_deal_product['price'])[0] ?></span></span>
                                                </span>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="content-bottom">
                                            <div class="countdown" data-countdown="2023/06/20"></div>
                                            <a href="#" data-hover="SHOP NOW">SHOP NOW</a>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                    </div>

                    <div class="col-lg-8 col-md-6 col-12 ps-3 ps-lg-4 ps-xl-5 mb-40">

                        <div class="row border-bottom mb-2">
                            <div class="section-title text-start col mb-30 d-flex justify-content-between align-items-center">
                                <div>
                                    <h1>On Sale Products</h1>
                                    <p>All featured product find here</p>
                                </div>
                                <a href="special-product.php?type=on-sale" class="see-more-btn">
                                    See More <span class="arrow">→</span>
                                </a>
                            </div>
                        </div>

                        <div class="small-product-slider row row-7 mbn-40">
                            <?php foreach ($productsOnSale as $productOnSale): ?>
                                <div class="col mb-40">
                                    <div class="on-sale-product">
                                        <a href="single-product.php?product_id=<?= $productOnSale['product_id'] ?>" class="image"><img src="admin-pages/<?= $productOnSale['image'] ?>" height="175" alt="Image"></a>
                                        <div class="content text-center">
                                            <h4 class="title"><a href="single-product.php?product_id=<?= $productOnSale['product_id'] ?>"><?= $productOnSale['name'] ?></a></h4>
                                            <span class="price"><?php if ($productOnSale['currency'] == "USD") {
                                                                    echo "$";
                                                                } else {
                                                                    echo 'L.L';
                                                                } ?>
                                                <?= $productOnSale['new_price'] ?> <span class="old"><?php if ($productOnSale['currency'] == "USD") {
                                                                                                            echo "$";
                                                                                                        } else {
                                                                                                            echo 'L.L';
                                                                                                        } ?><?= $productOnSale['price'] ?></span></span>
                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>
            </div>
        </div><!-- Product Section End -->

        <!-- Feature Section Start -->
        <div class="feature-section bg-theme-two section section-padding fix mb-5" style="background-image: url(assets/images/pattern/pattern-dot.png);">
            <div class="container">
                <div class="feature-wrap row justify-content-center mbn-30">

                    <div class="col-md-4 col-12 mb-30">
                        <div class="feature-item text-center">

                            <div class="icon"><img src="assets/images/feature/feature-1.png" alt="Image"></div>
                            <div class="content">
                                <h3>Free Delivery</h3>
                                <p>Start from $99</p>
                            </div>

                        </div>
                    </div>

                    <!-- <div class="col-md-4 col-12 mb-30">
                        <div class="feature-item text-center">

                            <div class="icon"><img src="assets/images/feature/feature-2.png" alt="Image"></div>
                            <div class="content">
                                <h3>Money Back Guarantee</h3>
                                <p>Back within 25 days</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 col-12 mb-30">
                        <div class="feature-item text-center">

                            <div class="icon"><img src="assets/images/feature/feature-3.png" alt="Image"></div>
                            <div class="content">
                                <h3>Secure Payment</h3>
                                <p>Payment Security</p>
                            </div>

                        </div>
                    </div> -->

                </div>
            </div>
        </div><!-- Feature Section End -->

        <!-- Brand Section Start -->
        <!-- <div class="brand-section section section-padding pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="brand-slider">

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-1.png" alt="Image">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-2.png" alt="Image">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-3.png" alt="Image">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-4.png" alt="Image">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-5.png" alt="Image">
                        </div>

                        <div class="brand-item col">
                            <img src="assets/images/brands/brand-6.png" alt="Image">
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
        <!-- Brand Section End -->

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
        $(document).ready(function() {
            setTimeout(function() {
                $('#floatingAlert').alert('close');
            }, 5000); // 5000 milliseconds = 5 seconds
        });

        $(document).ready(function() {
            $(".wishlist-btn").click(function() {
                var productId = $(this).data("product-id");
                var button = $(this);

                $.ajax({
                    url: "proccess/add_to_wishlist.php",
                    type: "POST",
                    data: {
                        product_id: productId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            button.text("Added to Wishlist").prop("disabled", true);
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