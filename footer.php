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
                    <input id="mc-email" autocomplete="off" placeholder="Enter your email here"
                        name="EMAIL" type="email">
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
                <p class="footer-copyright">© 2025 Calisto Baby. Made with <i class="fa fa-heart heart-icon"></i>
                    By <a target="_blank" href="mailto:hadimonzer1999@gmail.com">Hadi Monzer</a></p>
            </div>
        </div>
    </div>
</div><!-- Footer Bottom Section End -->