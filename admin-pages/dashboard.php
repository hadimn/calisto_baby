<?php

if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}

require_once "../classes/database.php";
require_once "../classes/product.php";
require_once "../classes/order.php";
require_once "../classes/customer.php";
require_once "../classes/tag.php";
require_once "../classes/discount.php";

$database = new Database();
$db = $database->getConnection();

// Initialize all classes
$product = new Product($db);
$order = new Order($db);
$customer = new Customer($db);
$tag = new Tag($db);
$discount = new Discount($db);

// Get statistics
$totalProducts = count($product->getAll()->fetchAll());
$totalOrders = count($order->getAllOrders()->fetchAll());
$totalCustomers = count($customer->getAll()->fetchAll());
$totalRevenue = $order->getTotalRevenue();
$pendingOrders = count($order->getByStatus('pending')->fetchAll());
$completedOrders = count($order->getByStatus('Delivered')->fetchAll());
$popularProducts = $product->getPorductsPopular();
$bestDealProducts = $product->getPorductsBestDeal();
$newArrivals = $product->newArrival();
$tagsWithCounts = $tag->getProductCountPerTag();
$activeDiscounts = $discount->getActiveDiscountsCount();

// Get recent orders
$recentOrders = $order->getAllOrders()->fetchAll(PDO::FETCH_ASSOC);
$recentOrders = array_slice($recentOrders, 0, 5);

// Get sales data for chart (last 7 days)
$salesData = $order->getSalesDataLast7Days();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Insights</title>
    <!-- Chart.js for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: rgba(160, 160, 160, 0.42);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            padding: 20px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #555;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .stat-card .icon {
            font-size: 2.5rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .recent-orders {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            border-top: none;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        .product-card {
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            height: 150px;
            object-fit: contain;
        }

        .section-title {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Admin Dashboard</h1>

        <!-- Overview Stats -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-archive" aria-hidden="true"></i></div>
                    <h3>Total Products</h3>
                    <div class="value"><?php echo $totalProducts; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                    <h3>Total Orders</h3>
                    <div class="value"><?php echo $totalOrders; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <h3>Total Customers</h3>
                    <div class="value"><?php echo $totalCustomers; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon"><i class="fa fa-money" aria-hidden="true"></i></div>
                    <h3>Total Revenue</h3>
                    <div class="value">$<?php echo number_format($totalRevenue, 2); ?></div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="chart-container">
                    <h3 class="section-title">Sales Last 7 Days</h3>
                    <canvas id="salesChart" height="250"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h3 class="section-title">Order Status</h3>
                    <canvas id="orderStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Popular Products -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="recent-orders">
                    <h3 class="section-title">Recent Orders</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order):
                                    $customer->customer_id = $order['customer_id'];
                                    $customer->findById();
                                ?>
                                    <tr>
                                        <td>#<?php echo $order['order_id']; ?></td>
                                        <td><?php echo htmlspecialchars($customer->first_name . ' ' . $customer->last_name); ?></td>
                                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $order['status'] == 'completed' ? 'completed' : 'pending'; ?>">
                                                <?php echo ucfirst($order['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3 class="section-title">Active Discounts</h3>
                    <div class="value" style="font-size: 2.5rem;"><?php echo $activeDiscounts; ?></div>
                    <p>Active discount codes</p>
                </div>

                <div class="stat-card mt-4">
                    <h3 class="section-title">Popular Tags</h3>
                    <ul class="list-group">
                        <?php foreach (array_slice($tagsWithCounts, 0, 5) as $tag): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($tag['name']); ?>
                                <span class="badge badge-primary badge-pill"><?php echo $tag['product_count']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product Highlights -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="section-title">Popular Products</h3>
                    <div class="row">
                        <?php foreach (array_slice($popularProducts, 0, 4) as $product): ?>
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text">$<?php echo htmlspecialchars($product['price']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="section-title">Best Deals</h3>
                    <div class="row">
                        <?php foreach ($bestDealProducts as $product):
                            $discountPercent = round((($product['price'] - $product['new_price']) / $product['price']) * 100);
                        ?>
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text">
                                            <span class="text-muted text-decoration-line-through">$<?php echo htmlspecialchars($product['price']); ?></span>
                                            <span class="text-danger"> $<?php echo htmlspecialchars($product['new_price']); ?></span>
                                            <span class="badge badge-danger"><?php echo $discountPercent; ?>% OFF</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="section-title">New Arrivals</h3>
                    <div class="row">
                        <?php foreach ($newArrivals as $product): ?>
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text">$<?php echo htmlspecialchars($product['price']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($salesData, 'date')); ?>,
                datasets: [{
                    label: 'Sales ($)',
                    data: <?php echo json_encode(array_column($salesData, 'total')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.raw.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });

        // Order Status Chart
        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [<?php echo $completedOrders; ?>, <?php echo $pendingOrders; ?>],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>