<?php include 'proccess/login-register-proccess.php'?>

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

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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

    <!-- twilio phone number input api -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
</head>

<body>

    <div class="main-wrapper">
        <!-- header Start -->
        <?php include 'header.php'?>
        <!-- header End -->
        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(assets/images/hero/hero-1.jpg)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Login & Register</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="wishlist.html">Wishlist</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row mbn-40">

                    <div class="col-lg-4 col-12 mb-40">
                        <div class="login-register-form-wrap">
                            <h3>Login</h3>
                            <?php if (isset($errors) && !empty($errors) && isset($_POST['login'])): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post" class="mb-30">
                                <div class="row">
                                    <div class="col-12 mb-15"><input type="email" name="login_email"
                                            placeholder="Email"></div>
                                    <div class="input-group mb-3" style="border-right-color:white;">
                                        <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                                        <input type="password" class="form-control" id="loginPassword"
                                            name="login_password" placeholder="Password" value=""
                                            style="border-right-color:white;">
                                        <span class="input-group-text" onclick="togglePassword('loginPassword', 'togglePassword')"
                                            style="cursor: pointer;  border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                            <i class="fa fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                    <!-- <div class="col-12 mb-15"><input type="password" name="login_password"
                                            placeholder="Password"></div> -->
                                    <div class="col-12"><input type="submit" name="login" value="Login"></div>
                                </div>
                            </form>
                            <h4>You can also login with...</h4>
                            <div class="social-login">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-12 mb-40 text-center d-none d-lg-block">
                        <span class="login-register-separator"></span>
                    </div>

                    <div class="col-lg-6 col-12 mb-40 ms-auto">
                        <div class="login-register-form-wrap">
                            <h3>Register</h3>
                            <?php if (isset($errors) && !empty($errors) && isset($_POST['register'])): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( isset($registration_success) && isset($_POST['register'])): ?>
                                <div class="alert alert-success">
                                    <p><?=$registration_success?></p>
                                </div>
                            <?php endif?>
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-15"><input type="text" name="first_name"
                                            placeholder="First Name"></div>
                                    <div class="col-md-6 col-12 mb-15"><input type="text" name="last_name"
                                            placeholder="Last Name"></div>
                                    <div class="col-md-6 col-12 mb-15"><input type="email" name="email"
                                            placeholder="Email"></div>
                                    <div class="col-md-6 col-12 mb-15"><input type="text" name="phone_number"
                                            placeholder="Phone Number"></div>
                                    <div class="col-12 mb-15"><input type="text" name="address" placeholder="Address">
                                    </div>
                                    <div class="input-group mb-3" style="border-right-color:white;">
                                        <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                                        <input type="password" class="form-control" id="registerPassword" name="password"
                                            placeholder="Password" value="" style="border-right-color:white;">
                                        <span class="input-group-text" onclick="togglePassword('registerPassword', 'togglePassword1')"
                                            style="cursor: pointer;  border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                            <i class="fa fa-eye" id="togglePassword1" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                    <div class="input-group mb-3" style="border-right-color:white;">
                                        <!-- <span class="input-group-text"><i class="fa fa-lock"></i></span> -->
                                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                                            placeholder="Confirm Password" value="" style="border-right-color:white;">
                                        <span class="input-group-text" onclick="togglePassword('confirmPassword', 'togglePassword2')"
                                            style="cursor: pointer;  border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                            <i class="fa fa-eye" id="togglePassword2" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                    <!-- <div class="col-md-6 col-12 mb-15"><input type="password" name="password"
                                            placeholder="Password"></div> -->
                                    <!-- <div class="col-md-6 col-12 mb-15"><input type="password" name="confirm_password"
                                            placeholder="Confirm Password"></div> -->
                                    <div class="col-md-6 col-12"><input type="submit" name="register" value="Register">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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

        <!-- Footer Top Section Start -->
        <div class="footer-top-section section bg-theme-two-light section-padding">
            <div class="container">
                <div class="row mbn-40">

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">CONTACT US</h4>
                        <p>You address will be here<br /> Lorem Ipsum text</p>
                        <p><a href="tel:01234567890">01234 567 890</a><a href="tel:01234567891">01234 567 891</a></p>
                        <p><a href="mailto:info@example.com">info@example.com</a><a href="#">www.example.com</a></p>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">PRODUCTS</h4>
                        <ul>
                            <li><a href="#">New Arrivals</a></li>
                            <li><a href="#">Best Seller</a></li>
                            <li><a href="#">Trendy Items</a></li>
                            <li><a href="#">Best Deals</a></li>
                            <li><a href="#">On Sale Products</a></li>
                            <li><a href="#">Featured Products</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">INFORMATION</h4>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Payment Method</a></li>
                            <li><a href="#">Product Warranty</a></li>
                            <li><a href="#">Return Process</a></li>
                            <li><a href="#">Payment Security</a></li>
                        </ul>
                    </div>

                    <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                        <h4 class="title">NEWSLETTER</h4>
                        <p>Subscribe our newsletter and get all update of our product</p>

                        <form id="mc-form" class="mc-form footer-subscribe-form">
                            <input id="mc-email" autocomplete="off" placeholder="Enter your email here" name="EMAIL"
                                type="email">
                            <button id="mc-submit"><i class="fa fa-paper-plane-o"></i></button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                        </div><!-- mailchimp-alerts end -->

                        <h5>FOLLOW US</h5>
                        <p class="footer-social"><a href="#">Facebook</a> - <a href="#">Twitter</a> - <a
                                href="#">Google+</a></p>

                    </div>

                </div>
            </div>
        </div><!-- Footer Top Section End -->

        <!-- Footer Bottom Section Start -->
        <div class="footer-bottom-section section bg-theme-two pt-15 pb-15">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <p class="footer-copyright">© 2022 Jadusona. Made with <i class="fa fa-heart heart-icon"></i> By
                            <a target="_blank" href="https://hasthemes.com">HasThemes</a>
                        </p>
                    </div>
                </div>
            </div>
        </div><!-- Footer Bottom Section End -->

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
        function togglePassword(passId, togglePassword) {
            const passwordInput = document.getElementById(passId);
            const toggleIcon = document.getElementById(togglePassword);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>