<?php
// checkout.php
session_start();
include 'classes/database.php';
include 'classes/cart.php';
include 'classes/customer.php';
include 'classes/billing_address.php';
@include('proccess/shipping_proccess.php');

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);
$customer->customer_id = $_SESSION['customer_id'];
$customer->findById();

// Check for existing billing address
$billingAddress = new BillingAddress($db);
$billingAddress->customer_id = $_SESSION['customer_id'];
$existingAddress = $billingAddress->getByCustomer();

$cart = new Cart($db);
$cart->customer_id = $_SESSION['customer_id'];

$cartItems = $cart->getItems()->fetchAll(PDO::FETCH_ASSOC);

if(!$cartItems){
    $_SESSION['error'] = "please add products to your cart before proceeding";
    header("Location: shop-left-sidebar.php");
    exit();
}

$totals = $cart->calculateCartTotals($_SESSION['customer_id']);
$subtotal = $totals['subtotal'];
$total = $totals['total'];

// Fetch the current shipping fee from the database
$query = "SELECT fee FROM shipping_fees LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$current_fee = isset($row) ? ($total < 99 ? $row['fee'] : '0.00') : '0.00';

// Fetch active discount for the customer
$discount = new Discount($db);
$discount->customer_id = $_SESSION['customer_id'];
$activeDiscount = $discount->getActiveDiscount();

$discountAmount = 0;
if ($activeDiscount) {
    $discountAmount = ($subtotal * $activeDiscount['discount_percentage']) / 100;
    $discountType = $activeDiscount['discount_type'];
}

$grandTotal = ($total - $discountAmount) + $current_fee;

// Display error messages if any
$error = isset($_GET['error']) ? $_GET['error'] : '';
$errorMessages = [
    'invalid_request' => 'Invalid request. Please try again.',
    'terms_not_accepted' => 'You must accept the terms and conditions to place an order.',
    'empty_cart' => 'Your cart is empty. Please add items before checking out.',
    'address_error' => 'There was an error saving your billing address.',
    'order_error' => 'There was an error creating your order.'
];

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
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/checkout.jpg)">
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
                <form action="proccess/place_order.php" method="POST" class="checkout-form">
                    <div class="row row-50 mbn-40">

                        <div class="col-lg-7">
                            <!-- Billing Address -->
                            <div id="billing-form" class="mb-20">
                                <h4 class="checkout-title">Billing Address</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-5">
                                        <label>First Name*</label>
                                        <input type="text" name="first_name" placeholder="First Name"
                                            value="<?= $existingAddress ? $existingAddress['first_name'] : $customer->first_name ?>" required>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Last Name*</label>
                                        <input type="text" name="last_name" placeholder="Last Name"
                                            value="<?= $existingAddress ? $existingAddress['last_name'] : $customer->last_name ?>" required>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Email Address*</label>
                                        <input type="email" name="email" placeholder="Email Address"
                                            value="<?= $existingAddress ? $existingAddress['email'] : $customer->email ?>" required>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Phone no*</label>
                                        <input type="text" name="phone_number" placeholder="Phone number"
                                            value="<?= $existingAddress ? $existingAddress['phone_number'] : $customer->phone_number ?>" required>
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Address*</label>
                                        <input type="text" name="address" placeholder="Address line"
                                            value="<?= $existingAddress ? $existingAddress['address'] : $customer->address ?>" required>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Country*</label>
                                        <select class="nice-select" name="country" required>
                                            <option value="Lebanon" <?= ($existingAddress && $existingAddress['country'] == 'Lebanon') || !$existingAddress ? 'selected' : '' ?>>Lebanon</option>
                                            <!-- Add more countries if needed -->
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-12 mb-5">
                                        <label>Town/City*</label>
                                        <input type="text" name="city" placeholder="Town/City"
                                            value="<?= $existingAddress ? $existingAddress['city'] : '' ?>" required>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <label class="form-label" for="textAreaExample6">Additional address information</label>
                                        <textarea style="border: #666666 solid 1px;" name="additional_info"
                                            placeholder="Additional information" class="form-control" id="textAreaExample6" rows="3"><?= $existingAddress ? $existingAddress['additional_info'] : '' ?></textarea>
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
                                                    <th>Q-S-C</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cartItems as $cartItem): ?>
                                                    <tr>
                                                        <td><?= $cartItem['product_name'] ?></td>
                                                        <td>
                                                            <?php if ($cartItem['new_price'] != null || $cartItem['new_price'] != 0): ?>
                                                                $<?= $cartItem['new_price'] ?>
                                                            <?php else: ?>
                                                                $<?= $cartItem['price'] ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $cartItem['quantity'] ?>-<?= $cartItem['size'] ?>-<?= $cartItem['color'] ?></td>
                                                        <td>$<?= $cart->getCartItemSubtotal($cartItem['cart_id']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <p>Sub Total <span>$<?= $subtotal ?></span></p>
                                        <?php if ($discountAmount > 0): ?>
                                            <p>Discount(<?= $discountType ?>  " <?=$activeDiscount['discount_percentage']?>% ") <span>-$<?= number_format($discountAmount, 2) ?></span></p>
                                        <?php endif; ?>
                                        <p>Shipping Fee <span>$<?= $current_fee ?></span></p>

                                        <h4>Grand Total <span>$<?= number_format($grandTotal, 2) ?></span></h4>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="col-12 mb-40">
                                    <h4 class="checkout-title">Payment Method</h4>

                                    <div class="checkout-payment-method">
                                        <!-- Cash Payment -->
                                        <div class="single-method">
                                            <input type="radio" id="payment_cash" name="payment-method" value="cash" checked>
                                            <label for="payment_cash">Cash Payment <span class="fa fa-caret-down"></span></label>
                                            <p data-method="cash">Pay with cash upon delivery. Our representative will collect the payment when your order is delivered to your address.</p>
                                        </div>

                                        <!-- Whish Money -->
                                        <!-- <div class="single-method">
                                            <input type="radio" id="payment_whish" name="payment-method" value="whish">
                                            <label for="payment_whish">Whish Money</label>
                                            <p data-method="whish">Pay securely using Whish Money. Complete your payment through the Whish Money platform for a fast and hassle-free transaction.</p>
                                        </div> -->

                                        <!-- Terms and Conditions -->
                                        <div class="single-method">
                                            <input type="checkbox" id="accept_terms" name="accept_terms" required>
                                            <label for="accept_terms">
                                                I’ve read and accept the
                                                <a href="assets/documents/terms-and-conditions.pdf" download style="color: blue;">
                                                    terms & conditions <span class="fa fa-download"></span>
                                                </a>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" name="place_order" class="place-order">Place order</button>
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