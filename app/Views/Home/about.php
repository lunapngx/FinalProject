<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>AboutPage<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="about-container">
        <h2>About Us</h2>
        <p class="about-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Vestibulum ante ipsum primis in faucibus.
        </p>

        <div class="about-content">
            <div class="about-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Vestibulum ante ipsum primis in faucibus.</p>
            </div>
            <div class="about-image">
                <img src="<?= base_url('assets/img/about-image.jpg') ?>" alt="About Us Image">
            </div>
        </div>
    </div>

<?= $this->endSection() ?>