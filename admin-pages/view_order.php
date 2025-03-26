<?php

use Classes\Order;
use Classes\OrderItem;

require_once '../classes/database.php';
require_once '../classes/order.php';
require_once '../classes/order-items.php';
require_once '../classes/customer.php';

$database = new Database();
$db = $database->getConnection();

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if (!$order_id) {
    header("Location: orderspage.php");
    exit();
}

$order = new Order($db);
$order->order_id = $order_id;
$orderDetails = $order->getOrderDetails();

// Verify this order belongs to the logged-in customer (or admin is viewing)
if (!$orderDetails || (!isset($_SESSION['admin']) && $orderDetails['customer_id'] != $_SESSION['customer_id'])) {
    header("Location: orderspage.php");
    exit();
}

// Get customer details
$customer = new Customer($db);
$customer->customer_id = $orderDetails['customer_id'];
$customer->findById();

$orderItem = new OrderItem($db);
$items = $orderItem->getOrderItems($order_id);

// Define the order status progression
$status_progression = [
    'pending' => 'preparing',
    'preparing' => 'paid',
    'paid' => 'delivered',
    'delivered' => null // Final state
];

// Handle status update if admin submitted the form
if (isset($_SESSION['admin_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
        $new_status = $_POST['new_status'];

        // Validate the status transition
        if ($new_status === $status_progression[$orderDetails['status']]) {
            $update_query = "UPDATE orders SET status = :status WHERE order_id = :order_id";
            $stmt = $db->prepare($update_query);
            $stmt->bindParam(":status", $new_status);
            $stmt->bindParam(":order_id", $order_id);

            if ($stmt->execute()) {
                // Refresh order details after update
                $orderDetails = $order->getOrderDetails();
                $success_message = "Order status updated successfully to " . ucfirst($new_status);
            } else {
                $error_message = "Failed to update order status";
            }
        } else {
            $error_message = "Invalid status transition";
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Order #<?= $order_id ?> - Jadusona</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/icon-font.min.css">
    <link rel="stylesheet" href="../assets/css/plugins.css">
    <link rel="stylesheet" href="../assets/css/helper.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .order-details-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .order-status {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-preparing {
            background: #cce5ff;
            color: #004085;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background: #d1ecf1;
            color: #0c5460;
        }

        .product-card {
            display: flex;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
            border-radius: 6px;
            background: #f9f9f9;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .product-info {
            flex: 1;
        }

        .product-price {
            font-weight: 600;
            color: #333;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-table tr:last-child td {
            border-bottom: none;
        }

        .summary-label {
            font-weight: 500;
        }

        .summary-value {
            text-align: right;
            font-weight: 600;
        }

        .grand-total {
            font-size: 18px;
            color: #333;
        }

        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success"><?= $success_message ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?= $error_message ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="order-details-card">

                            <div class="order-header">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3>Order #<?= $order_id ?></h3>
                                    <span class="order-status status-<?= $orderDetails['status'] ?>">
                                        <?= ucfirst($orderDetails['status']) ?>
                                    </span>
                                </div>
                                <p class="text-muted">Placed on <?= date('F j, Y \a\t g:i a', strtotime($orderDetails['created_at'])) ?></p>
                            </div>

                            <h4 class="mb-4">Order Items</h4>

                            <?php foreach ($items as $item): ?>
                                <div class="product-card">
                                    <img src="<?= $item['color_image'] ?>" alt="<?= $item['name'] ?>" class="product-img">
                                    <div class="product-info">
                                        <h5><?= $item['name'] ?></h5>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Qty: <?= $item['quantity'] ?></span>
                                            <span class="text-muted">color: <?= $item['color'] ?></span>
                                            <span class="text-muted">size: <?= $item['size'] ?></span>
                                            <span class="product-price">$<?= number_format($item['price_at_purchase'], 2) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Admin status update form -->
                            <?php if (isset($_SESSION['admin_id'])): ?>
                                <div class="status-update-form mt-4">
                                    <h5>Update Order Status</h5>
                                    <form method="POST" action="">
                                        <div class="d-flex gap-2">
                                            <?php
                                            $next_status = $status_progression[$orderDetails['status']];
                                            if ($next_status):
                                            ?>
                                                <input type="hidden" name="new_status" value="<?= $next_status ?>">
                                                <button type="submit" name="update_status" class="btn btn-primary">
                                                    Mark as <?= ucfirst($next_status) ?>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-secondary" disabled>
                                                    Order Completed
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>




                    <div class="col-lg-4">
                        <div class="order-details-card">
                            <h4 class="mb-4">Order Summary</h4>

                            <table class="summary-table mb-4">
                                <tr>
                                    <td class="summary-label">Subtotal</td>
                                    <td class="summary-value">$<?= number_format($orderDetails['total_amount'], 2) ?></td>
                                </tr>
                                <?php if ($orderDetails['discount_amount'] > 0): ?>
                                    <tr>
                                        <td class="summary-label">Discount</td>
                                        <td class="summary-value">-$<?= number_format($orderDetails['discount_amount'], 2) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="summary-label">Shipping Fee</td>
                                    <td class="summary-value">$<?= number_format($orderDetails['shipping_fee'], 2) ?></td>
                                </tr>
                                <tr>
                                    <td class="summary-label grand-total">Total</td>
                                    <td class="summary-value grand-total">
                                        $<?= number_format(($orderDetails['total_amount'] - $orderDetails['discount_amount'] + $orderDetails['shipping_fee']), 2) ?>
                                    </td>
                                </tr>
                            </table>

                            <h4 class="mb-3">Shipping Address</h4>
                            <address>
                                <p><strong><?= htmlspecialchars($customer->first_name) ?> <?= htmlspecialchars($customer->last_name) ?></strong></p>
                                <p><?= htmlspecialchars($customer->address) ?></p>
                                <p>Phone: <?= htmlspecialchars($customer->phone_number) ?></p>
                                <p>Email: <?= htmlspecialchars($customer->email) ?></p>
                            </address>

                            <h4 class="mb-3">Payment Method</h4>
                            <p>Cash on Delivery</p>

                            <a href="proccess/generate_bill.php?order_id=<?= $order_id ?>" class="btn btn-primary">Download Invoice</a>

                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Page Section End -->
    </div>

    <!-- JS -->
    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>