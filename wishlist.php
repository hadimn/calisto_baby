<?php
include 'classes/database.php';
include 'classes/cart.php';
include 'classes/wishlist.php';

session_start();
// Check if the user is logged in (modify this as per your authentication system)
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = "login please!";
    header("Location: login-register.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$wishlist = new Wishlist($db);
$wishlist->customer_id = $_SESSION['customer_id'];

$wishlistItems = $wishlist->getWishlistByCustomer();

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
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/whishlist.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Wishlist</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="wishlist.php">Wishlist</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <form action="#">
                    <div class="row">
                        <div class="col-12">
                            <div class="cart-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th class="pro-title">Product</th>
                                            <th class="pro-price">Price</th>
                                            <th class="pro-subtotal">Total</th>
                                            <th class="pro-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($wishlistItems)): ?>
                                            <?php foreach ($wishlistItems as $item): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="#"><img src="admin-pages/<?php echo $item['image']; ?>" alt="" height="50" width="50" /></a>
                                                    </td>
                                                    <td class="pro-title text-center"><a href="single-product.php?product_id=<?php echo $item['product_id']; ?>"><?php echo $item['name']; ?></a></td>
                                                    <td class="pro-price text-center">
                                                        <div class="content-right">
                                                            <?php if (!empty($item['new_price'])): ?>
                                                                <span class="price" style="color: #FF708A;">$<?= number_format($item['new_price'], 2) ?></span>
                                                                <span class="old-price" style="color: #94C7EB; text-decoration: line-through;">
                                                                    $<?= number_format($item['price'], 2) ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="price">$<?= number_format($item['price'], 2) ?></span>
                                                            <?php endif; ?>
                                                        </div>

                                                    <td class="pro-add-cart text-center">
                                                        <a href="single-product.php?product_id=<?php echo $item['product_id']; ?>">Add to Cart</a>
                                                    </td>
                                                    <td class="pro-remove text-center">
                                                        <a href="proccess/remove_wishlist.php?product_id=<?php echo $item['product_id']; ?>">×</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" style="text-align:center;">No items in your wishlist.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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

        <?php include 'footer.php'; ?>

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