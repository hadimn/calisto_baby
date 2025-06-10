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
    <title>Product Warranty - Calisto Baby</title>
    <meta name="description" content="Read about Calisto Baby's product warranty and coverage.">
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

        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/aboutUs.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Product Warranty</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="">Product Warranty</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Warranty Section -->
        <div class="section section-padding">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <h2 class="mb-3">Your Satisfaction Matters</h2>
                        <p class="lead text-muted">We stand by the quality of every Calisto Baby product. If something isn't right, we're here to make it better.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">What’s Covered</h4>
                            <ul class="list-unstyled">
                                <li>✔ Manufacturing defects</li>
                                <li>✔ Items received damaged or faulty</li>
                                <li>✔ Warranty claims must be reported within 7 days of delivery</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">What’s Not Covered</h4>
                            <ul class="list-unstyled text-danger">
                                <li>✘ General wear and tear</li>
                                <li>✘ Damage due to misuse or washing</li>
                                <li>✘ Sale or clearance items</li>
                                <li>✘ Items without tags or original packaging</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="mb-3">How to Submit a Claim</h4>
                            <p>Contact our support team with your order number, photos of the issue, and a short description of the problem:</p>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-envelope text-primary me-2"></i><a href="mailto:calistobaby1@gmail.com">calistobaby1@gmail.com</a></li>
                                <li><i class="fa fa-whatsapp text-success me-2"></i><a href="https://wa.me/96181972848">+961 81 972 848</a></li>
                            </ul>
                            <p class="text-muted mt-2">We aim to respond within 24 hours and resolve valid warranty issues promptly.</p>
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