<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>AboutPage<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="about-container">
        <h2 class="section-title"><b>About Meraki</b></h2>
        <p class="about-description">
            Meraki shopping cart system is a heartfelt brand that offers handmade crafts created with soul, creativity, and love. Specializing in crochet pieces, pins, fuzzy crafts, ribbon flower bouquets, other handcrafted pieces and customizable gift packages, Meraki transforms thoughtful gestures into tangible expressions of care. Every product is lovingly handcrafted to bring joy—not just to customers, but also to the special people they gift them to. Whether delivered personally or shipped with care, Meraki aims to create moments of happiness through meaningful, artfully made gifts.
        </p>

        <div class="mission-vision-boxes">
            <div class="box">
                <h3><b>Our Vision</b></h3>
                <p>
                    To become a beloved go-to brand for heartfelt handmade gifts, inspiring moments of joy and connection through soulful creations — from our hands to their hearts.                </p>
            </div>
            <div class="box">
                <h3><b>Our Mission</b></h3>
                <p>
                    At Meraki, we pour soul, creativity, and love into every handmade craft — from crochet art and ribbon bouquets to personalized gift packages. We exist to create meaningful, memorable gifts that bring smiles to our customers and their loved ones. As a young, independent creator, we strive to grow a community that celebrates thoughtfulness, supports local artisans, and brings handcrafted beauty closer to everyone — online, at school pop-up booths, and soon, in our very own physical store.</div>
            <div class="box">
                <h3><b>Our Values</b></h3>
                <p>
                    We value creativity by bringing new and fun ideas into our designs and show our passion by making each item with care and love. We focus on quality, making sure every product looks good and lasts long. We want to spread joy through special gifts that build a connection between people, and we always act with honesty and respect in everything we do.                </p>
            </div>
        </div>
        <div class="lower-image-container">
            <img src="<?= base_url('assets/img/meraki-logo.png') ?>" alt="Meraki Gift Shop Logo">
        </div>

    </div>

<?= $this->endSection() ?>