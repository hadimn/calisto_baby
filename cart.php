<?php
session_start();
include 'classes/database.php';
include 'classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = 'you need to be logged in.';
    header('Location: index.php');
}

$customer_id = $_SESSION['customer_id'];

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Fetch cart items
$cart = new Cart($db);
$cart->customer_id = $customer_id;
$stmt = $cart->getItems();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate cart totals
$totals = $cart->calculateCartTotals($customer_id);
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
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/myCart.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Cart</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="cart.php">Cart</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">

                <form action="#">
                    <div class="row mbn-40">
                        <div class="col-12 mb-40">
                            <div class="cart-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Image</th>
                                            <th class="pro-title">Product</th>
                                            <th class="pro-price">Price</th>
                                            <th class="pro-quantity">Quantity</th>
                                            <th class="pro-subtotal">Total</th>
                                            <th class="pro-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <!-- Display Cart Items -->
                                    <tbody>
                                        <?php foreach ($cart_items as $item): ?>
                                            <?php
                                            // Determine the correct price to display
                                            $price = $item['new_price'] !== null && $item['new_price'] > 0 ? $item['new_price'] : $item['price'];
                                            ?>
                                            <tr>
                                                <td class="pro-thumbnail">
                                                    <a href="#">
                                                        <img src="admin-pages/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" />
                                                    </a>
                                                </td>
                                                <td class="pro-title">
                                                    <a href="single-product.php?product_id=<?= htmlspecialchars($item['product_id']) ?>">
                                                        <?= htmlspecialchars($item['product_name']) ?>
                                                    </a>
                                                    <br>
                                                    <small>Color: <?= htmlspecialchars($item['color']) ?></small>
                                                    <br>
                                                    <small>Size: <?= htmlspecialchars($item['size']) ?></small>
                                                    <br>
                                                </td>
                                                <td class="pro-price">
                                                    <span class="amount">$<?= htmlspecialchars($price) ?></span>
                                                    <?php if ($item['new_price'] !== null && $item['new_price'] > 0): ?>
                                                        <span class="old-price" style="text-decoration: line-through; color: #999; margin-left: 10px;">
                                                            $<?= htmlspecialchars($item['price']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pro-quantity">
                                                    <div class="pro-qty">
                                                        <span class="dec qtybtn"><i class="ti-minus"></i></span>
                                                        <input type="text" value="<?= htmlspecialchars($item['quantity']) ?>" data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>">
                                                        <span class="inc qtybtn"><i class="ti-plus"></i></span>
                                                    </div>
                                                </td>
                                                <td class="pro-subtotal">
                                                    $<?= htmlspecialchars($price * $item['quantity']) ?>
                                                </td>
                                                <td class="pro-remove">
                                                    <a href="remove_from_cart.php?cart_id=<?= htmlspecialchars($item['cart_id']) ?>">×</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-7 col-12 mb-40">
                            <div class="cart-buttons mb-30">
                                <input type="submit" value="Update Cart" />
                                <a href="#" id="clear-cart-button">Clear Cart</a>
                                <a href="#">Continue Shopping</a>
                            </div>
                            <div class="cart-coupon">
                                <h4>Coupon</h4>
                                <p>Enter your coupon code if you have one.</p>
                                <div class="cuppon-form">
                                    <input type="text" placeholder="Coupon code" />
                                    <input type="submit" value="Apply Coupon" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-12 mb-40">
                            <div class="cart-total fix">
                                <h3>Cart Totals</h3>
                                <table>
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td><span class="amount">$<?= number_format($subtotal, 2) ?></span></td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td>
                                                <strong><span class="amount">$<?= number_format($total, 2) ?></span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="proceed-to-checkout section mt-30">
                                    <a href="checkout.php">Proceed to Checkout</a>
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
            // Handle remove item button clicks
            document.querySelectorAll('.pro-remove a').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the default link behavior

                    const cartId = this.getAttribute('href').split('=')[1]; // Extract cart_id from the URL

                    // Send an AJAX request to remove the item
                    fetch(`proccess/remove_from_cart.php?cart_id=${cartId}`, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Reload the page to reflect the updated cart
                                window.location.reload();
                            } else {
                                alert('Failed to remove item: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Handle clear cart button click
            document.getElementById('clear-cart-button').addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior

                // Send an AJAX request to clear the cart
                fetch('proccess/clear_cart.php', {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to reflect the updated cart
                            window.location.reload();
                        } else {
                            alert('Failed to clear cart: ' + data.message);
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