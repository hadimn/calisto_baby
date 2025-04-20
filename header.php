<?php
include_once 'classes/wishlist.php';

session_start();

if (isset($_SESSION['customer_id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $cart = new Cart($db);
    $cart->customer_id = $_SESSION['customer_id'];
    $cartCount = $cart->getCartCount();
    $totals = $cart->calculateCartTotals($cart->customer_id);
    $total = $totals['total'];

    $wishlist = new Wishlist($db);
    $wishlist->customer_id = $_SESSION['customer_id'];
    $wishlist_count = $wishlist->countWishlistItems();
}

?>

<div class="header-section section">

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
                                <span>
                                    <?php if(isset($wishlist_count)):?>
                                    <?= $wishlist_count ?>
                                    <?php else:?>
                                    00
                                    <?php endif;?>  
                                </span>
                            </a>
                        </div>

                        <div class="header-mini-cart">
                            <a href="cart.php">
                                <img src="assets/images/icons/cart.png" alt="Cart">
                                <span>
                                    <?php if (isset($cartCount) && isset($totals)): ?>
                                        <?= $cartCount ?>($<?= $total ?>)
                                    <?php else: ?>
                                        00($0.00)
                                    <?php endif; ?>
                                </span>
                            </a>
                        </div>

                        <!-- Profile Button with Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-link profile-toggle" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="assets/images/icons/profile.png" alt="Profile"
                                    style="width: 30px; height: 30px;">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <?php if (isset($_SESSION['customer_id']) && $_SESSION['logged_in'] == true): ?>
                                    <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                                    <li><a class="dropdown-item" href="proccess/logout-proccess.php">Logout</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="login-register.php">Login & Register</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div><!-- Header Advance Search End -->
                </div>

                <div class="col order-3 order-lg-2">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'index.php'): ?>active<?php endif ?>"><a href="index.php">HOME</a>
                                </li>
                                <li <?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'shop.php'): ?>active<?php endif ?>><a
                                        href="shop-left-sidebar.php">SHOP</a></li>
                                <li><a href="#">PAGES</a>
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
                                    </ul>
                                </li>
                                <li><a href="blog.php">BLOG</a>
                                    <ul class="sub-menu">
                                        <li><a href="blog.php">Blog</a></li>
                                        <li><a href="single-blog.php">Single Blog</a></li>
                                    </ul>
                                </li>
                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'contact.php'): ?>active<?php endif ?>"><a
                                        href="contact.php">CONTACT</a></li>
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