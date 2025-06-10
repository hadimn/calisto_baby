<?php
require_once "classes/tag.php";

$tag = new Tag($db);

$tags = $tag->getAll();
?>

<!-- Footer Top Section Start -->
<div class="footer-top-section section bg-theme-two-light section-padding">
    <div class="container">
        <div class="row mbn-40">

            <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                <h4 class="title">CONTACT US</h4>
                <p>Beirut, Lebanon</p>
                <p><a href="tel:+961 81 972 848">+961 81 972 848</a></p>
                <p><a href="mailto:calistobaby1@gmail.com">calistobaby1@gmail.com</a>
                </p>
            </div>

            <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                <h4 class="title">CATEGORIES</h4>
                <ul>
                    <?php foreach ($tags as $tag): ?>
                        <li><a href="shop-left-sidebar.php?tag=<?= $tag['tag_id'] ?>"><?= $tag['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                <h4 class="title">INFORMATION</h4>
                <ul>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="assets/documents/terms-and-conditions.pdf" download>Terms & Conditions</a></li>
                    <li><a href="#">Payment Method: cash</a></li>
                    <li><a href="waranty.php">Product Warranty</a></li>
                    <li><a href="return-proccess.php">Return Process</a></li>
                </ul>
            </div>

            <div class="footer-widget col-lg-3 col-md-6 col-12 mb-40">
                <h5 class="title">FOLLOW US</h5>
                <p class="footer-social">
                    <a href="https://www.facebook.com/profile.php?id=100077276937756" target="_blank">Facebook</a> -
                    <a href="https://www.instagram.com/calistobaby.lb?igsh=eXJzNXp1aTUxNnRz" target="_blank">Instagram</a> -
                    <a href="https://www.tiktok.com/@calistobaby?_t=ZS-8tdIAqM8t4D&_r=1" target="_blank">TikTok</a>
                </p>
            </div>


        </div>
    </div>
</div><!-- Footer Top Section End -->

<!-- Footer Bottom Section Start -->
<div class="footer-bottom-section section bg-theme-two pt-15 pb-15">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <p class="footer-copyright">© 2025 Calisto Baby. Made with <i class="fa fa-heart heart-icon"></i>
                    By <a target="_blank" href="mailto:hadimonzer1999@gmail.com">Hadi Monzer</a></p>
            </div>
        </div>
    </div>
</div><!-- Footer Bottom Section End -->