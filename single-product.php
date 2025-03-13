<?php
include 'classes/database.php';
include 'classes/product.php';

if (isset($_GET['product_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);
    $product->product_id = $_GET['product_id'];
    $prod = $product->getById();
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

                                <div class="pro-large-img mb-10 fix easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                    <a href="assets/images/product/product-zoom-1.jpg">
                                        <img src="assets/images/product/product-big-1.jpg" alt="" />
                                    </a>
                                </div>
                                <!-- Single Product Thumbnail Slider -->
                                <ul id="pro-thumb-img" class="pro-thumb-img">
                                    <li><a href="assets/images/product/product-zoom-1.jpg" data-standard="assets/images/product/product-big-1.jpg"><img src="assets/images/product/product-1.jpg" alt="" /></a></li>
                                    <li><a href="assets/images/product/product-zoom-2.jpg" data-standard="assets/images/product/product-big-2.jpg"><img src="assets/images/product/product-2.jpg" alt="" /></a></li>
                                    <li><a href="assets/images/product/product-zoom-3.jpg" data-standard="assets/images/product/product-big-3.jpg"><img src="assets/images/product/product-3.jpg" alt="" /></a></li>
                                    <li><a href="assets/images/product/product-zoom-4.jpg" data-standard="assets/images/product/product-big-4.jpg"><img src="assets/images/product/product-4.jpg" alt="" /></a></li>
                                    <li><a href="assets/images/product/product-zoom-5.jpg" data-standard="assets/images/product/product-big-5.jpg"><img src="assets/images/product/product-5.jpg" alt="" /></a></li>
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

                                        <div class="quantity">
                                            <h5>Quantity:</h5>
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>

                                        <div class="colors">
                                            <h5>Color:</h5>
                                            <div class="color-options">
                                                <button style="background-color: #ff502e"></button>
                                                <button style="background-color: #fff600"></button>
                                                <button style="background-color: #1b2436"></button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="actions">

                                        <button><i class="ti-shopping-cart"></i><span>ADD TO CART</span></button>
                                        <button class="box" data-tooltip="Compare"><i class="ti-control-shuffle"></i></button>
                                        <button class="box" data-tooltip="Wishlist"><i class="ti-heart"></i></button>

                                    </div>

                                    <div class="tags">

                                        <h5>Tags:</h5>
                                        <a href="#">Electronic</a>
                                        <a href="#">Smartphone</a>
                                        <a href="#">Phone</a>
                                        <a href="#">Charger</a>
                                        <a href="#">Powerbank</a>

                                    </div>

                                    <div class="share">

                                        <h5>Share: </h5>
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-google-plus"></i></a>

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
                                    <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
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

                    <div class="slick-slide">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img src="assets/images/product/product-1.jpg" alt="">

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

                                        <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                        <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span style="background-color: #0271bc"></span><span style="background-color: #efc87c"></span><span style="background-color: #00c183"></span></h5>

                                    </div>

                                    <div class="content-right">
                                        <span class="price">$25</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="slick-slide">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img src="assets/images/product/product-2.jpg" alt="">

                                    <div class="image-overlay">
                                        <div class="action-buttons">
                                            <button>add to cart</button>
                                            <button>add to wishlist</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">

                                    <div class="content-left">

                                        <h4 class="title"><a href="single-product.html">Jumpsuit Outfits</a></h4>

                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>

                                        <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                        <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span style="background-color: #0271bc"></span><span style="background-color: #efc87c"></span><span style="background-color: #00c183"></span></h5>

                                    </div>

                                    <div class="content-right">
                                        <span class="price">$09</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="slick-slide">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img src="assets/images/product/product-3.jpg" alt="">

                                    <div class="image-overlay">
                                        <div class="action-buttons">
                                            <button>add to cart</button>
                                            <button>add to wishlist</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">

                                    <div class="content-left">

                                        <h4 class="title"><a href="single-product.html">Smart Shirt</a></h4>

                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>

                                        <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                        <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span style="background-color: #0271bc"></span><span style="background-color: #efc87c"></span><span style="background-color: #00c183"></span></h5>

                                    </div>

                                    <div class="content-right">
                                        <span class="price">$18</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="slick-slide">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img src="assets/images/product/product-4.jpg" alt="">

                                    <div class="image-overlay">
                                        <div class="action-buttons">
                                            <button>add to cart</button>
                                            <button>add to wishlist</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">

                                    <div class="content-left">

                                        <h4 class="title"><a href="single-product.html">Kids Shoe</a></h4>

                                        <div class="ratting">
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
                                        <span class="price">$15</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="slick-slide">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img src="assets/images/product/product-5.jpg" alt="">

                                    <div class="image-overlay">
                                        <div class="action-buttons">
                                            <button>add to cart</button>
                                            <button>add to wishlist</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">

                                    <div class="content-left">

                                        <h4 class="title"><a href="single-product.html"> Bowknot Bodysuit</a></h4>

                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>

                                        <h5 class="size">Size: <span>S</span><span>M</span><span>L</span><span>XL</span></h5>
                                        <h5 class="color">Color: <span style="background-color: #ffb2b0"></span><span style="background-color: #0271bc"></span><span style="background-color: #efc87c"></span><span style="background-color: #00c183"></span></h5>

                                    </div>

                                    <div class="content-right">
                                        <span class="price">$12</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

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

        <!-- Footer Top Section Start -->
        <div class="footer-top-section section bg-theme-two-light section-padding">
            <div class="container">
                <div class="row mbn-40">

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">CONTACT US</h4>
                        <p>You address will be here<br /> Lorem Ipsum text</p>
                        <p><a href="tel:01234567890">01234 567 890</a><a href="tel:01234567891">01234 567 891</a></p>
                        <p><a href="mailto:info@example.com">info@example.com</a><a href="#">www.example.com</a></p>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">PRODUCTS</h4>
                        <ul>
                            <li><a href="#">New Arrivals</a></li>
                            <li><a href="#">Best Seller</a></li>
                            <li><a href="#">Trendy Items</a></li>
                            <li><a href="#">Best Deals</a></li>
                            <li><a href="#">On Sale Products</a></li>
                            <li><a href="#">Featured Products</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">INFORMATION</h4>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Payment Method</a></li>
                            <li><a href="#">Product Warranty</a></li>
                            <li><a href="#">Return Process</a></li>
                            <li><a href="#">Payment Security</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">NEWSLETTER</h4>
                        <p>Subscribe our newsletter and get all update of our product</p>

                        <form id="mc-form" class="mc-form footer-subscribe-form">
                            <input id="mc-email" autocomplete="off" placeholder="Enter your email here" name="EMAIL" type="email">
                            <button id="mc-submit"><i class="fa fa-paper-plane-o"></i></button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                        </div><!-- mailchimp-alerts end -->

                        <h5>FOLLOW US</h5>
                        <p class="footer-social"><a href="#">Facebook</a> - <a href="#">Twitter</a> - <a href="#">Google+</a></p>

                    </div>

                </div>
            </div>
        </div><!-- Footer Top Section End -->

        <!-- Footer Bottom Section Start -->
        <div class="footer-bottom-section section bg-theme-two pt-15 pb-15">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <p class="footer-copyright">© 2022 Jadusona. Made with <i class="fa fa-heart heart-icon"></i> By <a target="_blank" href="https://hasthemes.com">HasThemes</a></p>
                    </div>
                </div>
            </div>
        </div><!-- Footer Bottom Section End -->

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