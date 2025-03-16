<?php
include "classes/database.php";
include "classes/product.php";

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// on sale products
$productsOnSale = $product->getPorductsOnSale();
// last three products
$productLastthree = $product->getLastByLimit(3);
// popular products
$popular_products = $product->getPorductsPopular();
// best_deal products
$best_deal_products = $product->getPorductsBestDeal();

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
</head>

<body>

    <div class="main-wrapper">

        <?php include 'header.php' ?>

        <!-- Hero Section Start "last 4 on-sale products" -->
        <div class="hero-section section">

            <!-- Hero Slider Start -->
            <div class="hero-slider hero-slider-one fix">

                <?php foreach ($productsOnSale as $productOS): ?>
                    <!-- Hero Item Start -->
                    <div class="hero-item" style="background-image: url(admin-pages/<?= $productOS['image'] ?>); background-size: cover">

                        <!-- Hero Content -->
                        <div class="hero-content">
                            <h1><?= $productOS['name'] ?> <br><?php echo htmlspecialchars(substr($productOS['description'], 0, 50)); ?>...</h1>
                            <a href="#">SHOP NOW</a>
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

                            <a href="#" class="image"><img src="assets/images/feature/newArrival.jpg" alt="Banner Image" style="height: 210px;"></a>

                            <div class="content">
                                <h1 style="color: #FF7790;">New Arrival <br>Baby’s clothes <br>GET ALL YOU WANT</h1>
                                <a href="#" data-hover="SHOP NOW">SHOP NOW</a>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-20">
                        <a href="#" class="banner banner-2">

                            <img src="assets/images/feature/newBorn.jpg" alt="Banner Image" style="height: 210px;">

                            <div class="content bg-theme-one">
                                <h1>New Toy’s for your Baby</h1>
                            </div>

                            <!-- <span class="banner-offer">25% off</span> -->

                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-20">
                        <div class="banner banner-1 content-left content-top">

                            <a href="#" class="image"><img src="assets/images/feature/mustHave.jpg" alt="Banner Image" style="height: 210px;"></a>

                            <div class="content">
                                <h1 style="color: #FF7790;">Must <br>Have Basics</h1>
                                <a href="#" data-hover="SHOP NOW">SHOP NOW</a>
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

                <div class="row">
                    <div class="section-title text-center col mb-30">
                        <h1>Popular Products</h1>
                        <p>All popular product find here</p>
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
                                                <button>add to cart</button>
                                                <button>add to wishlist</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="content">

                                        <div class="content-left">

                                            <h4 class="title"><a href="single-product.php?product_id=<?=$popular_product['product_id']?>"><?= $popular_product['name'] ?></a></h4>

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
                                            <span class="price">$<?= explode(".", $popular_product['price'])[0] ?><?php if (explode(".", $popular_product['price'])[1] != "00") {
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
            <div class="row row-5 mbn-10">

                <div class="col-lg-4 col-md-6 col-12 mb-10">
                    <div class="banner banner-3">

                        <a href="#" class="image"><img src="assets/images/feature/boyClothes.jpg" alt="Banner Image" height="280"></a>

                        <div class="content" style="background-image: url(assets/images/banner/banner-3-shape.png)">
                            <h1>Boy Clothing</h1>
                            <h2>Calisto </h2>
                            <h4>2 - 5 Years</h4>
                        </div>

                        <a href="#" class="shop-link" data-hover="SHOP NOW">SHOP NOW</a>

                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-10">
                    <div class="banner banner-4">

                        <a href="#" class="image"><img src="assets/images/feature/accessoriesMore.jpg" height="280" alt="Banner Image"></a>

                        <div class="content">
                            <div class="content-inner">
                                <h1>Accessories & More</h1>
                                <h2>Adorable Picks <br>New Trend for <?= date("Y") ?></h2>
                                <a href="#" data-hover="SHOP NOW">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-10">
                    <div class="banner banner-5">

                        <a href="#" class="image"><img src="assets/images/feature/girlClothes.jpg" alt="Banner Image" height="280"></a>

                        <div class="content" style="background-image: url(assets/images/banner/banner-5-shape.png)">
                            <h1>Girls Clothing <br>Baby Girl’s</h1>
                            <h2>Trendy Styles</h2>
                        </div>

                        <a href="#" class="shop-link" data-hover="SHOP NOW">SHOP NOW</a>

                    </div>
                </div>

            </div>
        </div><!-- Banner Section End -->

        <!-- best deal section -->
        <!-- Product Section Start -->
        <div class="product-section section section-padding pt-0">
            <div class="container">
                <div class="row mbn-40">

                    <div class="col-lg-4 col-md-6 col-12 mb-40">

                        <div class="row">
                            <div class="section-title text-start col mb-30">
                                <h1>Best Deal</h1>
                                <p>Exclusive deals for you</p>
                            </div>
                        </div>

                        <div class="best-deal-slider w-100">

                            <?php foreach ($best_deal_products as $best_deal_product): ?>
                                <div class="slide-item">

                                    <div class="best-deal-product">

                                        <div class="image"><img src="admin-pages/<?= $best_deal_product['image'] ?>" height="540" alt="Image"></div>

                                        <div class="content-top">

                                            <div class="content-top-left" style="width: 50%;">
                                                <h4 class="title"><a href="#"><?= $best_deal_product['name'] ?></a></h4>
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
                                                    <span class="old">$<?= explode(".",$best_deal_product['price'])[0] ?></span></span>
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

                        <div class="row">
                            <div class="section-title text-start col mb-30">
                                <h1>On Sale Products</h1>
                                <p>All featured product find here</p>
                            </div>
                        </div>

                        <div class="small-product-slider row row-7 mbn-40">
                            <?php foreach ($productsOnSale as $productOnSale): ?>
                                <div class="col mb-40">
                                    <div class="on-sale-product">
                                        <a href="single-product.php?product_id=<?=$productOnSale['product_id']?>" class="image"><img src="admin-pages/<?= $productOnSale['image'] ?>" height="175" alt="Image"></a>
                                        <div class="content text-center">
                                            <h4 class="title"><a href="single-product.php?product_id=<?=$productOnSale['product_id']?>"><?= $productOnSale['name'] ?></a></h4>
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
        <div class="feature-section bg-theme-two section section-padding fix" style="background-image: url(assets/images/pattern/pattern-dot.png);">
            <div class="container">
                <div class="feature-wrap row justify-content-between mbn-30">

                    <div class="col-md-4 col-12 mb-30">
                        <div class="feature-item text-center">

                            <div class="icon"><img src="assets/images/feature/feature-1.png" alt="Image"></div>
                            <div class="content">
                                <h3>Free Shipping</h3>
                                <p>Start from $100</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 col-12 mb-30">
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
                    </div>

                </div>
            </div>
        </div><!-- Feature Section End -->

        <!-- Blog Section Start -->
        <div class="blog-section section section-padding">
            <div class="container">
                <div class="row mbn-40">

                    <div class="col-xl-6 col-lg-5 col-12 mb-40">

                        <div class="row">
                            <div class="section-title text-start col mb-30">
                                <h1>CLIENTS REVIEW</h1>
                                <p>Clients says abot us</p>
                            </div>
                        </div>

                        <div class="row mbn-40">

                            <div class="col-12 mb-40">
                                <div class="testimonial-item">
                                    <p>Jadusona is one of the most exclusive Baby shop in the wold, where you can find all product for your baby that your want to buy for your baby. I recomanded this shop all of you</p>
                                    <div class="testimonial-author">
                                        <img src="assets/images/testimonial/testimonial-1.png" alt="Image">
                                        <div class="content">
                                            <h4>Zacquline Smith</h4>
                                            <p>CEO, Momens Group</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-40">
                                <div class="testimonial-item">
                                    <p>Jadusona is one of the most exclusive Baby shop in the wold, where you can find all product for your baby that your want to buy for your baby. I recomanded this shop all of you</p>
                                    <div class="testimonial-author">
                                        <img src="assets/images/testimonial/testimonial-2.png" alt="Image">
                                        <div class="content">
                                            <h4>Nusaha Williams</h4>
                                            <p>CEO, Momens Group</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-7 col-12 mb-40">

                        <div class="row">
                            <div class="section-title text-start col mb-30">
                                <h1>FROM THE BLOG</h1>
                                <p>Find all latest update here</p>
                            </div>
                        </div>

                        <div class="row mbn-40">

                            <div class="col-12 mb-40">
                                <div class="blog-item">
                                    <div class="image-wrap">
                                        <h4 class="date">May <span>25</span></h4>
                                        <a class="image" href="single-blog.php"><img src="assets/images/blog/blog-1.jpg" alt="Image"></a>
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="single-blog.php">Lates and new Trens for baby fashion</a></h4>
                                        <div class="desc">
                                            <p>Jadusona is one of the most of a exclusive Baby shop in the</p>
                                        </div>
                                        <ul class="meta">
                                            <li><a href="#"><img src="assets/images/blog/blog-author-1.jpg" alt="Blog Author">Muhin</a></li>
                                            <li><a href="#">25 Likes</a></li>
                                            <li><a href="#">05 Views</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-40">
                                <div class="blog-item">
                                    <div class="image-wrap">
                                        <h4 class="date">May <span>20</span></h4>
                                        <a class="image" href="single-blog.php"><img src="assets/images/blog/blog-2.jpg" alt="Image"></a>
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="single-blog.php">New Collection New Trend all New Style</a></h4>
                                        <div class="desc">
                                            <p>Jadusona is one of the most of a exclusive Baby shop in the</p>
                                        </div>
                                        <ul class="meta">
                                            <li><a href="#"><img src="assets/images/blog/blog-author-2.jpg" alt="Blog Author">Takiya</a></li>
                                            <li><a href="#">25 Likes</a></li>
                                            <li><a href="#">05 Views</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div><!-- Blog Section End -->

        <!-- Brand Section Start -->
        <div class="brand-section section section-padding pt-0">
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
        </div><!-- Brand Section End -->

        <?php include 'footer.php'?>

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

</body>

</html>