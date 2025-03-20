<?php
session_start();

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$cart->customer_id = $_SESSION['customer_id'];
$cartCount = $cart->getCartCount();
$totals = $cart->calculateCartTotals($cart->customer_id);
$total = $totals['total'];

?>


<div class="header-section section">

    <!-- Header Top Start -->
    <div class="header-top header-top-one bg-theme-two">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">

                <div class="col mt-10 mb-10 d-none d-md-flex">
                    <!-- Header Top Left Start -->
                    <div class="header-top-left">
                        <p>Welcome to Jadusona</p>
                        <p>Hotline: <a href="tel:0123456789">0123 456 789</a></p>
                    </div><!-- Header Top Left End -->
                </div>

                <!-- Header Language Currency Start -->
                <!-- <div class="col mt-10 mb-10">
                    <ul class="header-lan-curr">

                        <li><a href="#">eng</a>
                            <ul>
                                <li><a href="#">english</a></li>
                                <li><a href="#">spanish</a></li>
                                <li><a href="#">france</a></li>
                                <li><a href="#">russian</a></li>
                                <li><a href="#">chinese</a></li>
                            </ul>
                        </li>

                        <li><a href="#">$usd</a>
                            <ul>
                                <li><a href="#">pound</a></li>
                                <li><a href="#">dollar</a></li>
                                <li><a href="#">euro</a></li>
                                <li><a href="#">yen</a></li>
                            </ul>
                        </li>

                    </div>
                </ul> -->
                <!-- Header Language Currency End -->

                <div class="col mt-10 mb-10">
                    <!-- Header Shop Links Start -->
                    <div class="header-top-right">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                            <div style="display: flex; align-items: center;">
                                <p style="margin-right: 10px; <?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'my-account.php'): ?>color:#FF7B8D<?php endif ?>"><a href="my-account.php">My Account</a></p>
                                <form action="proccess/logout-proccess.php" method="post">
                                    <button type="submit" class="btn btn-danger">Logout</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <p><a href="login-register.php">Register</a><a href="login-register.php">Login</a></p>
                        <?php endif; ?>
                    </div><!-- Header Shop Links End -->
                </div>

            </div>
        </div>
    </div><!-- Header Top End -->

    <!-- Header Bottom Start -->
    <div class="header-bottom header-bottom-one header-sticky">
        <div class="container-fluid">
            <div class="row menu-center align-items-center justify-content-between">

                <div class="col mt-15 mb-15">
                    <!-- Logo Start -->
                    <div class="header-logo">
                        <a href="index.php">
                            <img src="assets/images/logo.png" alt="Jadusona">
                        </a>
                    </div><!-- Logo End -->
                </div>

                <div class="col order-2 order-lg-3">
                    <!-- Header Advance Search Start -->
                    <div class="header-shop-links">

                        <div class="header-search">
                            <button class="search-toggle"><img src="assets/images/icons/search.png"
                                    alt="Search Toggle"><img class="toggle-close" src="assets/images/icons/close.png"
                                    alt="Search Toggle"></button>
                            <div class="header-search-wrap">
                                <form action="#">
                                    <input type="text" placeholder="Type and hit enter">
                                    <button><img src="assets/images/icons/search.png" alt="Search"></button>
                                </form>
                            </div>
                        </div>

                        <div class="header-wishlist">
                            <a href="wishlist.php"><img src="assets/images/icons/wishlist.png" alt="Wishlist">
                                <span>02</span></a>
                        </div>

                        <div class="header-mini-cart">
                            <a href="cart.php"><img src="assets/images/icons/cart.png" alt="Cart">
                                <span><?= $cartCount ?>($<?= $total ?>)</span></a>
                        </div>

                    </div><!-- Header Advance Search End -->
                </div>

                <div class="col order-3 order-lg-2">
                    <div class="main-menu">
                        <nav>
                            <ul>

                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'index.php'): ?>active<?php endif ?>"><a href="index.php">HOME</a></li>
                                <li <?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'shop.php'): ?>active<?php endif ?>><a href="shop.php">SHOP</a>
                                    <ul class="sub-menu">
                                        <li><a href="shop.php">Shop</a></li>
                                        <li><a href="shop-left-sidebar.php">Shop Left Sidebar</a></li>
                                        <li><a href="shop-right-sidebar.php">Shop Right Sidebar</a></li>
                                        <li><a href="single-product.php">Single Product</a></li>
                                        <li><a href="single-product-left-sidebar.php">Single Product Left Sidebar</a>
                                        </li>
                                        <li><a href="single-product-right-sidebar.php">Single Product Right Sidebar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=""><a href="#">PAGES</a>
                                    <ul class="sub-menu">
                                        <li><a href="cart.php">Cart</a></li>
                                        <li><a href="checkout.php">Checkout</a></li>
                                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                                            <li><a href="proccess/logout-proccess.php">logout</a></li>
                                        <?php else: ?>
                                            <li class="active"><a href="login-register.php">Login & Register</a></li>
                                        <?php endif ?>
                                        <li><a href="my-account.php">My Account</a></li>
                                        <li><a href="wishlist.php">Wishlist</a></li>
                                        <!-- <li><a href="404.php">404 Error</a></li> -->
                                    </ul>
                                </li>
                                <li><a href="blog.php">BLOG</a>
                                    <ul class="sub-menu">
                                        <li><a href="blog.php">Blog</a></li>
                                        <li><a href="single-blog.php">Single Blog</a></li>
                                    </ul>
                                </li>
                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'contact.php'): ?>active<?php endif ?>"><a href="contact.php">CONTACT</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div class="mobile-menu order-4 d-block d-lg-none col"></div>

            </div>
        </div>
    </div><!-- Header BOttom End -->

</div><!-- Header Section End -->