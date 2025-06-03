<?php
use Classes\OrderItem;

session_start();
include 'classes/database.php';
include 'classes/order.php';
include 'classes/order-items.php';
include 'classes/cart.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = 'You need to be logged in.';
    header('Location: index.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (!isset($_GET['order_id'])) {
    $_SESSION['error'] = 'Invalid order.';
    header('Location: my-account.php');
    exit();
}

$order_id = $_GET['order_id'];

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$order->order_id = $order_id;
$order_details = $order->getOrderDetails();

if (!$order_details) {
    $_SESSION['error'] = 'Order not found.';
    error_log('order not found!');
    header('Location: shop-left-sidebar.php');
    exit();
}


$order_items = new OrderItem($db);
$order_items->order_id = $order_id;
$items = $order_items->getOrderItems($order_items->order_id);

session_abort();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/myAccount.png)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Orders</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">Order Details </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->
        <div class="page-section section section-padding">
            <div class="container">

                <div class="myaccount-table table-responsive text-center">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="pro-thumbnail">
                                        <a href="#">
                                            <img src="admin-pages/<?= htmlspecialchars($item['image']) ?>"
                                                alt="<?= htmlspecialchars($item['name']) ?>" height="100" class="mx-auto d-block" />
                                        </a>
                                    </td>
                                    <td>
                                        <a href="single-product.php?product_id=<?= htmlspecialchars($item['product_id']) ?>">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?=htmlspecialchars($item['size'])?>
                                    </td>
                                    <td>
                                        <?=htmlspecialchars($item['color'])?>
                                    </td>
                                    <td>
                                        <span class="amount">$<?= htmlspecialchars($item['price_at_purchase']) ?></span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($item['quantity']) ?>
                                    </td>
                                    <td>
                                        $<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>


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

</html>