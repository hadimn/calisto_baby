<?php

use Classes\Order;

session_start();
include "classes/database.php";
include "classes/customer.php";
include "classes/cart.php";
include "classes/order.php";

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);
$customer->customer_id = $_SESSION['customer_id'];
$customer->findById();

$order = new Order($db);
$order->customer_id = $customer->customer_id;
$orders = $order->getByCustomer();

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

        <?php include 'header.php' ?>

        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/myAccount.png)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>My Account</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="my-account.php">My Account</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row mbn-30">

                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
                        unset($_SESSION['success_message']); // Clear success message after showing
                    }

                    if (isset($_SESSION['error_message'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
                        unset($_SESSION['error_message']); // Clear error message after showing
                    }
                    ?>

                    <!-- My Account Tab Menu Start -->
                    <div class="col-lg-3 col-12 mb-30">
                        <div class="myaccount-tab-menu nav" role="tablist">
                            <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                Dashboard</a>

                            <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>

                            <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a>

                            <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                Method</a>

                            <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>

                            <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>

                            <a href="login-register.php"><i class="fa fa-sign-out"></i> Logout</a>
                        </div>
                    </div>
                    <!-- My Account Tab Menu End -->

                    <!-- My Account Tab Content Start -->
                    <div class="col-lg-9 col-12 mb-30">
                        <div class="tab-content" id="myaccountContent">
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Dashboard</h3>

                                    <div class="welcome">
                                        <p>Hello, <strong><?= $customer->first_name ?> <?= $customer->last_name ?></strong> (If Not <strong><?= $customer->last_name ?> !</strong> <a href="proccess/logout-proccess.php" class="logout"> Logout</a>)</p>
                                    </div>

                                    <p class="mb-0">From your account dashboard. you can easily check &amp; view your
                                        recent orders, manage your shipping and billing addresses and edit your
                                        password and account details.</p>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->

                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Orders</h3>

                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Currency</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $index = 1; ?>
                                                <?php while ($row = $orders->fetch(PDO::FETCH_ASSOC)) : ?>
                                                    <tr>
                                                        <td><?php echo $index++; ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['currency']); ?></td>
                                                        <td><a href="single-order.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-dark btn-round">View</a></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->

                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="download" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Downloads</h3>

                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Date</th>
                                                    <th>Expire</th>
                                                    <th>Download</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>Moisturizing Oil</td>
                                                    <td>Aug 22, 2022</td>
                                                    <td>Yes</td>
                                                    <td><a href="#" class="btn btn-dark btn-round">Download File</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Katopeno Altuni</td>
                                                    <td>Sep 12, 2022</td>
                                                    <td>Never</td>
                                                    <td><a href="#" class="btn btn-dark btn-round">Download File</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->

                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Payment Method</h3>

                                    <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->

                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Billing Address</h3>

                                    <address>
                                        <p><strong><?= $customer->first_name ?> <?= $customer->last_name ?></strong></p>
                                        <p><?= $customer->address ?><br></p>
                                        <p>Mobile: <?= $customer->phone_number ?></p>
                                    </address>

                                    <a href="#" class="btn btn-dark btn-round d-inline-block"><i class="fa fa-edit"></i>Edit Address</a>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->

                            <!-- Single Tab Content Start -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="account-info" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Account Details</h3>

                                    <div class="account-details-form">
                                        <form method="POST" action="proccess/update-contact-proccess.php">
                                            <div class="row">
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input id="first-name" name="first_name" placeholder="First Name" type="text" value="<?= htmlspecialchars($customer->first_name) ?>" required>
                                                </div>
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input id="last-name" name="last_name" placeholder="Last Name" type="text" value="<?= htmlspecialchars($customer->last_name) ?>" required>
                                                </div>
                                                <div class="col-12 mb-30">
                                                    <input id="email" name="email" placeholder="Email Address" type="email" value="<?= htmlspecialchars($customer->email) ?>" required>
                                                </div>
                                                <div class="col-12 mb-30">
                                                    <input id="phone_number" name="phone_number" placeholder="Phone Number" type="text" value="<?= htmlspecialchars($customer->phone_number) ?>">
                                                </div>
                                                <div class="col-12 mb-30">
                                                    <input id="address" name="address" placeholder="Address" type="text" value="<?= htmlspecialchars($customer->address) ?>">
                                                </div>

                                                <div class="col-12 mb-30">
                                                    <h4>Password Change (Optional)</h4>
                                                </div>
                                                <div class="col-12 mb-30">
                                                    <input id="current-pwd" name="current_password" placeholder="Current Password" type="password">
                                                </div>
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input id="new-pwd" name="new_password" placeholder="New Password" type="password">
                                                </div>
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input id="confirm-pwd" name="confirm_password" placeholder="Confirm Password" type="password">
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-dark btn-round btn-lg">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Tab Content End -->
                        </div>
                    </div>
                    <!-- My Account Tab Content End -->

                </div>
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

        <?php include 'footer.php' ?>
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