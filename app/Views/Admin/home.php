0<?= $this->extend('layouts/admin_master') ?>

<?= $this->section('title') ?>Meraki Shop<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="ecommerce-hero-1 hero section" id="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
                    <div class="content">
                        <span class="promo-badge"></span>
                        <h1>Admin <span>Shop</span></h1>
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

    </div>

    </section><?= $this->endSection() ?>