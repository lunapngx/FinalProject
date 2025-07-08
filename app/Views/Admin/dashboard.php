<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>Admin Dashboard<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/admin.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container admin-dashboard-page">
        <div class="admin-header-nav mb-4 bg-white py-3 shadow-sm rounded-bottom">
            <div class="container d-flex justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="<?= url_to('admin_dashboard') ?>">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_products') ?>">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_orders') ?>">ORDERS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_sales_report') ?>">SALES REPORT</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_account') ?>">ADMIN ACCOUNT</a></li>
                </ul>
            </div>
        </div>

        <div class="row dashboard-cards mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">TOTAL SALES</h5>
                        <p class="card-text">₱ <?= esc(number_format($totalSales ?? 0, 2)) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">WEEKLY ORDERS</h5>
                        <p class="card-text"><?= esc($weeklyOrders ?? 0) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">CUSTOMERS</h5>
                        <p class="card-text"><?= esc($customersCount ?? 0) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">PRODUCTS</h5>
                        <p class="card-text"><?= esc($productsCount ?? 0) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row dashboard-images">
            <div class="col-md-6 mb-4">
                <div class="image-card">
                    <img src="<?= base_url('public/assets/img/dashboard/admin_image_1.jpg') ?>" alt="Admin Dashboard Image 1" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="image-card">
                    <img src="<?= base_url('public/assets/img/dashboard/admin_image_2.jpg') ?>" alt="Admin Dashboard Image 2" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>