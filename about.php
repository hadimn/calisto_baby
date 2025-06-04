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
    <title>About Us - Calisto Baby</title>
    <meta name="description" content="Learn more about Calisto Baby – our story, values and mission.">
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
                        <h1>About Us</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="">about us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Banner Section End -->

        <!-- About Content Section -->
        <div class="section section-padding">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <h2 class="mb-3">Welcome to Calisto Baby</h2>
                        <p class="lead text-muted">A vibrant and imaginative world for newborns, toddlers, and parents who want only the best for their little ones.</p>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">Our Story</h4>
                            <p>Founded in 2020, Calisto Baby started with a simple mission: to make baby shopping joyful, accessible, and stylish. With over 10,000 satisfied customers, our journey continues to grow thanks to your trust and love.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">Why Calisto?</h4>
                            <p>"Calisto" is derived from the Greek <em>kallistos</em>, meaning “most beautiful.” That’s exactly how we want every baby to feel with our lovingly curated clothes and accessories.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">Our Values</h4>
                            <ul class="list-unstyled">
                                <li>✔ Colorful designs that spark imagination</li>
                                <li>✔ Iconic prints with practical cuts</li>
                                <li>✔ 100% cotton and organic fabrics</li>
                                <li>✔ Real photography — what you see is what you get</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 bg-light shadow-sm rounded h-100">
                            <h4 class="mb-3">Our Mission</h4>
                            <p>We aim to offer a wardrobe for babies and toddlers that blends fashion, comfort, and affordability. Our team works around the clock to ensure a seamless experience from click to delivery.</p>
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