<?php
include_once 'classes/wishlist.php';
include_once 'classes/banner_messages.php';

session_start();

$bannerM = new BannerMessage($db);
$bannerMessages = $bannerM->getAllActive()->fetchAll(PDO::FETCH_ASSOC);

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

<style>
    .top-banner {
        background-color: black;
        color: white;
        padding: 8px 0;
        overflow: hidden;
    }

    .message-container {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    .scrolling-text {
        white-space: nowrap;
        display: inline-block;
        font-size: 14px;
        animation: moveMessage 7s linear;
    }

    @keyframes moveMessage {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>

<!-- Catchable Scrolling Message Banner -->
<div class="top-banner">
    <div class="message-container">
        <div id="scrolling-text" class="scrolling-text">
            <!-- Message will appear here -->
        </div>
    </div>
</div>




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
                                    <?php if (isset($wishlist_count)): ?>
                                        <?= $wishlist_count ?>
                                    <?php else: ?>
                                        0
                                    <?php endif; ?>
                                </span>
                            </a>
                        </div>

                        <div class="header-mini-cart">
                            <a href="cart.php">
                                <img src="assets/images/icons/cart.png" alt="Cart">
                                <span>
                                    <?php if (isset($cartCount) && isset($totals)): ?>
                                        <?= $cartCount ?>
                                    <?php else: ?>
                                        0
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
                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'shop-left-sidebar.php'): ?>active<?php endif ?>">
                                    <a href="shop-left-sidebar.php">
                                        Categories
                                    </a>
                                </li>
                                <li><a href="#">PAGES</a>
                                    <ul class="sub-menu">
                                        <li><a href="cart.php">Cart</a></li>
                                        <li><a href="checkout.php">Checkout</a></li>
                                        <li><a href="my-account.php">My Account</a></li>
                                        <li><a href="wishlist.php">Wishlist</a></li>
                                        <li><a href="about.php">About Us</a></li>
                                        <li><a href="waranty.php">Product Warranty</a></li>
                                        <li><a href="return-proccess.php">Return Process</a></li>
                                    </ul>
                                </li>
                                <li class="<?php if (explode('/', $_SERVER['PHP_SELF'])[2] == 'contact.php'): ?>active<?php endif ?>">
                                    <a href="contact.php">
                                        CONTACT
                                    </a>
                                </li>
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

<script>
    const messages = [
        <?php foreach ($bannerMessages as $bannerMessage): ?> "<?= $bannerMessage['message'] ?>",
        <?php endforeach; ?>
    ];

    const textEl = document.getElementById("scrolling-text");
    let index = 0;

    function showNextMessage() {
        textEl.style.animation = "none";
        void textEl.offsetWidth; // restart animation
        textEl.textContent = messages[index];
        textEl.style.animation = "moveMessage 10s linear";

        index = (index + 1) % messages.length;
    }

    textEl.addEventListener("animationend", showNextMessage);

    // Start with the first message
    showNextMessage();
</script>