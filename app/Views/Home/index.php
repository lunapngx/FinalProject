<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>Meraki Shop<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="ecommerce-hero-1 hero section" id="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
                    <div class="content">
                        <span class="promo-badge"></span>
                        <h1>Meraki <span>Shop</span></h1>
                        <p>Meraki shopping cart system is a heartfelt brand that offers handmade crafts created with soul, creativity, and love. Specializing in crochet pieces, pins, fuzzy crafts, ribbon flower bouquets, other handcrafted pieces and customizable gift packages, Meraki transforms thoughtful gestures into tangible expressions of care. Every product is lovingly handcrafted to bring joy—not just to customers, but also to the special people they gift them to. Whether delivered personally or shipped with care, Meraki aims to create moments of happiness through meaningful, artfully made gifts</p>
                        <div class="hero-cta">
                            <a href="<?= base_url('products') ?>" class="btn btn-shop">Shop Now <i class="bi bi-arrow-right"></i></a>
                            <a href="<?= base_url('products') ?>" class="btn btn-collection">View Collection</a>
                        </div>
                    </div>
                </div>
            </div>
    </section><section id="info-cards" class="info-cards section light-background"

    <div class="container" data-aos="fade-up" data-aos-delay="100">
    </div>

    </section><section id="category-cards" class="category-cards section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="category-slider swiper init-swiper">
    <section id="best-sellers" class="best-sellers section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Best Sellers</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= base_url('assets/img/Product/Product-1.jpg') ?>" class="img-fluid default-image" alt="Product" loading="lazy">
                        <img src="<?= base_url('assets/img/Product/Product-5.jpg') ?>" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                        <div class="product-tags">
                            <span class="badge bg-accent">New</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn-quickview" type="button" aria-label="Quick view">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="<?= url_to('product_detail', 1) ?>">Lorem ipsum dolor sit amet</a></h3>
                        <div class="product-price">
                            <span class="current-price">$89.99</span>
                        </div>
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="rating-count">(42)</span>
                        </div>
                        <button class="btn btn-add-to-cart">
                            <i class="bi bi-bag-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= base_url('assets/img/Product/Product-4.webp') ?>" class="img-fluid default-image" alt="Product" loading="lazy">
                        <img src="<?= base_url('assets/img/Product/Product-4-variant.webp') ?>" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                        <div class="product-tags">
                            <span class="badge bg-sale">Sale</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn-quickview" type="button" aria-label="Quick view">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="<?= base_url('products/2') ?>">Consectetur adipiscing elit</a></h3>
                        <div class="product-price">
                            <span class="current-price">$64.99</span>
                            <span class="original-price">$79.99</span>
                        </div>
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="rating-count">(28)</span>
                        </div>
                        <button class="btn btn-add-to-cart">
                            <i class="bi bi-bag-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= base_url('assets/img/Product/Product-7.webp') ?>" class="img-fluid default-image" alt="Product" loading="lazy">
                        <img src="<?= base_url('assets/img/Product/Product-7-variant.webp') ?>" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                        <div class="product-actions">
                            <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn-quickview" type="button" aria-label="Quick view">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="<?= base_url('products/3') ?>">Sed do eiusmod tempor incididunt</a></h3>
                        <div class="product-price">
                            <span class="current-price">$119.00</span>
                        </div>
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="rating-count">(56)</span>
                        </div>
                        <button class="btn btn-add-to-cart">
                            <i class="bi bi-bag-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?= base_url('assets/img/Product/Product-12.webp') ?>" class="img-fluid default-image" alt="Product" loading="lazy">
                        <img src="<?= base_url('assets/img/Product/Product-12-variant.webp') ?>" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                        <div class="product-tags">
                            <span class="badge bg-sold-out">Sold Out</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn-quickview" type="button" aria-label="Quick view">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="<?= base_url('products/4') ?>">Ut labore et dolore magna aliqua</a></h3>
                        <div class="product-price">
                            <span class="current-price">$75.50</span>
                        </div>
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <i class="bi bi-star"></i>
                            <span class="rating-count">(15)</span>
                        </div>
                        <button class="btn btn-add-to-cart btn-disabled" disabled="">
                            <i class="bi bi-bag-plus me-2"></i>Sold Out
                        </button>
                    </div>
                </div>
            </div></div>

    </div>

    </section><?= $this->endSection() ?>