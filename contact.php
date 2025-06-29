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
        <div class="page-banner-section section" style="background-image: url(assets/images/feature/contactUs.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Contact us</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="contact.php">Contact us</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="contact-info-wrap col-md-6 col-12 mb-40">
                        <h3>Get in Touch</h3>
                        <p>At Calisto Baby, we believe every baby deserves comfort, care, and style. Whether you have a question, need assistance with an order, or simply want to share your experience, we’re here for you. Reach out to us anytime — our team is happy to help and always just a message away.</p>
                        <ul class="contact-info list-unstyled">
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <p>Beirut, lebanon</p>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <p><a href="#">+961 81 972 848</a></p>
                            </li>
                            <li>
                                <i class="fa fa-globe"></i>
                                <p><a href="#"> calistobaby1@gmail.com </a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- Page Section End -->

        <!-- Social Media Section Start -->
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
                                    <a href="<?= $platform['link'] ?>" target="_blank" class="btn btn-lg " style="background-color: <?= $platform['bg_color'] ?>;">
                                        <i class="<?= $platform['icon_class'] ?> me-2"></i> <?= $platform['platform']; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Social Media Section End -->

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


</body>

</html>