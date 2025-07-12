<footer id="footer" class="footer">

    <!-- Newsletter Section -->
    <div class="footer-newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2>Enjoy Shopping!</h2>
                    <form action="#" method="post" class="php-email-form">
                        <div class="newsletter-form d-flex">
                            <input type="email" name="email" placeholder="Your email address" required="">
                            <button type="submit">Subscribe</button>
                        </div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <div class="footer-main">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-widget footer-about">
                        <a href="<?= base_url('/') ?>" class="logo">
                            <span class="sitename">Meraki Shop</span>
                        </a>
                        <p></p>
                        <div class="footer-contact mt-4">
                            <div class="contact-item">
                                <i class="bi bi-geo-alt"></i>
                                <span></span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-telephone"></i>
                                <span></span>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-envelope"></i>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h4>Shop</h4>
                        <ul class="footer-links">
                            <li><a href="<?= base_url('products') ?>">New Arrivals</a></li>
                            <li><a href="<?= base_url('products') ?>">Bestsellers</a></li>
                            <li><a href="<?= base_url('products') ?>">Our Flowers</a></li>
                            <li><a href="<?= base_url('products') ?>">Arrangements</a></li>
                            <li><a href="<?= base_url('products') ?>">Occasions</a></li>
                            <li><a href="<?= base_url('products') ?>">Sale</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h4>Support</h4>
                        <ul class="footer-links">
                            <li><a href="#">Help Center</a></li>
                            <li><a href="<?= base_url('account/orders') ?>">Order Status</a></li>
                            <li><a href="#">Shipping Info</a></li>
                            <li><a href="#">Returns &amp; Exchanges</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="social-links mt-4">
                            <h5>Follow Us</h5>
                            <div class="social-icons">
                                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                                <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                                <a href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
                                <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="footer-bottom">
        <div class="container">
            <div class="legal-links text-center mt-2">
                <a href="#">Terms and Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>

            <div class="copyright text-center mt-2">
                <p>© <?= date('Y') ?> <strong class="sitename">Your Flower Shop</strong>. All Rights Reserved.</p>
            </div
        </div>
    </div>
</footer>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

<!-- JS Libraries -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/php-email-form/validate.js') ?>"></script>
<script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/aos/aos.js') ?>"></script>
<script src="<?= base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/drift-zoom/Drift.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/purecounter/purecounter_vanilla.js') ?>"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
