<?php
include 'classes/database.php';
include 'classes/social-media.php';
include 'classes/cart.php';

$database = new Database();
$db = $database->getConnection();
$stmt = new SocialMedia($db);

$platforms = $stmt->getAllSocialMedia();
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Returns & Exchanges - Calisto Baby</title>
    <meta name="description" content="Learn about Calisto Baby's return and exchange policies.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icon-font.min.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/helper.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
</head>

<body>
<div class="main-wrapper">

    <?php include 'header.php'; ?>

    <!-- Page Banner -->
    <div class="page-banner-section section" style="background-image: url(assets/images/feature/returns.jpg)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col text-center">
                    <h1 class="text-white">Returns & Exchanges</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li>Returns</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Returns Policy Section -->
    <div class="section section-padding">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="mb-3">Return & Exchange Policy</h2>
                    <p class="lead text-muted">We want you to feel confident when shopping with Calisto Baby. Here's how we handle returns, exchanges, and cancellations.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <h4 class="mb-3">Exchange Policy</h4>
                        <p>We accept exchanges within <strong>2 days</strong> of receiving your order (non-sale items only).</p>
                        <ul class="list-unstyled mb-0">
                            <li>✔ Items must be unused, tagged, and in original packaging</li>
                            <li>✔ Proof of purchase required</li>
                            <li class="text-danger">✘ No exchanges for pacifiers, feeding/breastfeeding products, socks, footwear, or underwear</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <h4 class="mb-3">Refund & Return Policy</h4>
                        <p><strong>No returns or refunds</strong> are offered. We provide exchanges only, and you must contact us within 2 days of receipt.</p>
                        <p>Customers are responsible for exchange shipping fees, which are non-refundable.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <h4 class="mb-3">How to Request an Exchange</h4>
                        <p>Contact us with your order number and reason for exchange via:</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-envelope text-primary me-2"></i><a href="mailto:calistobaby1@gmail.com">calistobaby1@gmail.com</a></li>
                            <li><i class="fa fa-whatsapp text-success me-2"></i><a href="https://wa.me/96181972848">+961 81 972 848</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-4 shadow-sm rounded bg-light h-100">
                        <h4 class="mb-3">Order Cancellations</h4>
                        <p>Our system processes orders immediately. We cannot make changes once the order is placed. If the order has not shipped yet, we may be able to cancel it.</p>
                        <p>Please contact us <strong>immediately</strong> via email or WhatsApp with the subject “Cancel”.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="social-media-section section section-padding bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-4">
                    <h3>Follow Us on Social Media</h3>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <?php foreach ($platforms as $platform): ?>
                            <?php if ($platform['enabled'] == 1): ?>
                                <a href="<?= $platform['link'] ?>" target="_blank" class="btn btn-lg" style="background-color: <?= $platform['bg_color'] ?>;">
                                    <i class="<?= $platform['icon_class'] ?> me-2"></i> <?= $platform['platform']; ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</div>

<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
