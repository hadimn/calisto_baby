<?php
session_start();
include 'classes/database.php';
include 'classes/cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$cart->customer_id = $_SESSION['customer_id'];

$cartItems = $cart->getItems()->fetchAll(PDO::FETCH_ASSOC);

// $Itemsubtotal = $cart->getCartItemSubtotal($_GET['cart_id']);
// print_r($Itemsubtotal);

$totals = $cart->calculateCartTotals($_SESSION['customer_id']);
$subtotal = $totals['subtotal'];
$total = $totals['total'];
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
        <div class="page-banner-section section" style="background-image: url(assets/images/hero/hero-1.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Checkout</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">

                <!-- Checkout Form s-->
                <form action="#" class="checkout-form">
                    <div class="row row-50 mbn-40">

                        <div class="col-lg-7">

                            <!-- Billing Address -->
                            <div id="billing-form" class="mb-20">
                                <h4 class="checkout-title">Billing Address</h4>

                                <div class="row">

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>First Name*</label>
                                        <input type="text" placeholder="First Name">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Last Name*</label>
                                        <input type="text" placeholder="Last Name">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Email Address*</label>
                                        <input type="email" placeholder="Email Address">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Phone no*</label>
                                        <input type="text" placeholder="Phone number">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Address*</label>
                                        <input type="text" placeholder="Address line 1">
                                        <input type="text" placeholder="Address line 2">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Country*</label>
                                        <select class="nice-select">
                                            <option>Lebanon</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Town/City*</label>
                                        <input type="text" placeholder="Town/City">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>State*</label>
                                        <input type="text" placeholder="State">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Zip Code*</label>
                                        <input type="text" placeholder="Zip Code">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <div class="check-box mb-15">
                                            <input type="checkbox" id="create_account">
                                            <label for="create_account">Create an Acount?</label>
                                        </div>
                                        <div class="check-box mb-15">
                                            <input type="checkbox" id="shiping_address" data-shipping>
                                            <label for="shiping_address">Ship to Different Address</label>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- Shipping Address -->
                            <div id="shipping-form" class="mb-20">
                                <h4 class="checkout-title">Shipping Address</h4>

                                <div class="row">

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>First Name*</label>
                                        <input type="text" placeholder="First Name">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Last Name*</label>
                                        <input type="text" placeholder="Last Name">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Email Address*</label>
                                        <input type="email" placeholder="Email Address">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Phone no*</label>
                                        <input type="text" placeholder="Phone number">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Address*</label>
                                        <input type="text" placeholder="Address line 1">
                                        <input type="text" placeholder="Address line 2">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Country*</label>
                                        <select class="nice-select">
                                            <option>Lebanon</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Town/City*</label>
                                        <input type="text" placeholder="Town/City">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>State*</label>
                                        <input type="text" placeholder="State">
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Zip Code*</label>
                                        <input type="text" placeholder="Zip Code">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-5">
                            <div class="row">

                                <!-- Cart Total -->
                                <div class="col-12 mb-40">

                                    <h4 class="checkout-title">Cart Total</h4>

                                    <div class="checkout-cart-total">

                                        <h4>Product</h4>
                                        <table class="cart-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cartItems as $cartItem): ?>
                                                    <tr>
                                                        <td><?= $cartItem['product_name'] ?></td>
                                                        <td>
                                                            <?php if ($cartItem['price'] != null || $cartItem['price'] != 0): ?>
                                                                $<?= $cartItem['price'] ?>
                                                            <?php else: ?>
                                                                $<?= $cartItem['new_price'] ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $cartItem['quantity'] ?> <?= $cartItem['size'] ?></td>
                                                        <td>$<?=$cart->getCartItemSubtotal($cartItem['cart_id']);?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <p>Sub Total <span>$<?= $subtotal ?></span></p>
                                        <p>Shipping Fee <span>$00.00</span></p>

                                        <h4>Grand Total <span>$1250.00</span></h4>

                                    </div>

                                </div>

                                <!-- Payment Method -->
                                <div class="col-12 mb-40">
                                    <h4 class="checkout-title">Payment Method</h4>

                                    <div class="checkout-payment-method">
                                        <!-- Cash Payment -->
                                        <div class="single-method">
                                            <input type="radio" id="payment_cash" name="payment-method" value="cash">
                                            <label for="payment_cash">Cash Payment</label>
                                            <p data-method="cash">Pay with cash upon delivery. Our representative will collect the payment when your order is delivered to your address.</p>
                                        </div>

                                        <!-- Whish Money -->
                                        <div class="single-method">
                                            <input type="radio" id="payment_whish" name="payment-method" value="whish">
                                            <label for="payment_whish">Whish Money</label>
                                            <p data-method="whish">Pay securely using Whish Money. Complete your payment through the Whish Money platform for a fast and hassle-free transaction.</p>
                                        </div>

                                        <!-- Terms and Conditions -->
                                        <div class="single-method">
                                            <input type="checkbox" id="accept_terms">
                                            <label for="accept_terms">I’ve read and accept the terms & conditions</label>
                                        </div>
                                    </div>

                                    <button class="place-order">Place order</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div><!-- Page Section End -->

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