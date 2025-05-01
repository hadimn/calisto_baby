<?php
use Classes\Order;
use Classes\OrderItem;

if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
  }

// Required files
require_once '../classes/database.php';
require_once '../classes/order.php';
require_once '../classes/order-items.php';

// Create DB connection and objects
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$orderItem = new OrderItem($db);

// Get status filter from URL or default to all
$status_filter = $_GET['status'] ?? 'all';

// Fetch orders based on filter
if ($status_filter === 'all') {
    $orders = $order->getAllOrders()->fetchAll(PDO::FETCH_ASSOC);
} else {
    $orders = $order->getByStatus($status_filter)->fetchAll(PDO::FETCH_ASSOC);
}

// Sort orders by date (newest first)
usort($orders, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>


    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>My Orders - Jadusona</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/icon-font.min.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/helper.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <style>
            .order-row {
                font-size: 14px;
            }

            .order-product-img-small {
                width: 30px;
                height: 30px;
                border-radius: 5px;
            }

            .order-list {
                border: 1px solid #ddd;
                border-radius: 5px;
                background: #fff;
            }

            .order-filter {
                margin-bottom: 30px;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .order-filter .btn {
                padding: 8px 20px;
                border-radius: 4px;
                font-weight: 500;
            }

            .order-card {
                border: 1px solid #eee;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                background: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            .order-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }

            .order-status {
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
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

            .order-product {
                display: flex;
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #f5f5f5;
            }

            .order-product:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            .order-product-img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
                margin-right: 15px;
            }

            .order-product-info {
                flex: 1;
            }

            .order-total {
                text-align: right;
                margin-top: 15px;
                font-size: 18px;
                font-weight: 600;
            }

            .no-orders {
                text-align: center;
                padding: 50px;
                background: #f9f9f9;
                border-radius: 8px;
            }
        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <div class="page-section section section-padding">
                <div class="container">
                    <div class="order-filter mb-3">
                        <a href="index.php?file=orderspage.php&status=all" class="btn <?= $status_filter === 'all' ? 'btn-dark' : 'btn-outline-dark' ?>">All Orders</a>
                        <a href="index.php?file=orderspage.php&status=pending" class="btn <?= $status_filter === 'pending' ? 'btn-dark' : 'btn-outline-dark' ?>">Pending</a>
                        <a href="index.php?file=orderspage.php&status=preparing" class="btn <?= $status_filter === 'preparing' ? 'btn-dark' : 'btn-outline-dark' ?>">Preparing</a>
                        <a href="index.php?file=orderspage.php&status=paid" class="btn <?= $status_filter === 'paid' ? 'btn-dark' : 'btn-outline-dark' ?>">Paid</a>
                        <a href="index.php?file=orderspage.php&status=delivered" class="btn <?= $status_filter === 'delivered' ? 'btn-dark' : 'btn-outline-dark' ?>">Delivered</a>
                    </div>

                    <?php if (empty($orders)): ?>
                        <div class="no-orders text-center">
                            <h3>No orders found</h3>
                        </div>
                    <?php else: ?>
                        <div class="order-list">
                            <?php foreach ($orders as $order): ?>
                                <?php $items = $orderItem->getOrderItems($order['order_id']); ?>
                                <div class="order-row d-flex align-items-center justify-content-between p-2 border-bottom">
                                    <div class="order-info d-flex align-items-center">
                                        <span class="order-id fw-bold">#<?= $order['order_id'] ?></span>
                                        <small class="text-muted ms-2">(<?= date('M j, Y', strtotime($order['created_at'])) ?>)</small>
                                    </div>
                                    <div class="order-items d-flex">
                                        <?php foreach ($items as $item): ?>
                                            <div class="d-flex align-items-center me-3">
                                                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="order-product-img-small me-2">
                                                <span class="small">x<?= $item['quantity'] ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="order-status badge bg-secondary text-white">
                                        <?= ucfirst($order['status']) ?>
                                    </div>
                                    <div class="order-total fw-bold">
                                        $<?= number_format($order['total_amount'], 2) ?>
                                    </div>
                                    <div>
                                        <a href="index.php?file=view_order.php&order_id=<?= $order['order_id'] ?>" class="btn btn-outline-primary btn-sm">View Order</a>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- JS -->
        <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
        <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
    </body>

    </html>