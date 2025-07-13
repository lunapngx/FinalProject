<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>My Account<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="profile-menu">
                    <div class="user-info text-center">
                        <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="User Avatar">
                        <h5 class="mb-1"><?= session()->get('user_name') ?? 'Guest' ?></h5>
                        <p class="text-muted"><?= session()->get('user_email') ?? 'N/A' ?></p>
                        <hr>
                    </div>
                    <ul class="nav flex-column menu-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= url_to('account') ?>">
                                <i class="bi bi-person-circle"></i> My Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url_to('account_orders') ?>">
                                <i class="bi bi-bag-check"></i> My Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url_to('account_wishlist') ?>">
                                <i class="bi bi-heart"></i> My Wishlist
                            </a>
                        </li>
                    </ul>
                    <div class="menu-footer">
                        <a href="<?= url_to('logout') ?>" class="logout-link">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content-area">
                    <div class="section-header">
                        <h2>Welcome to Your Account!</h2>
                    </div>
                    <p>This is your personal account dashboard. You can manage your profile, view your orders, and see your wishlist from here.</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-bag-check me-2"></i>My Orders</h5>
                                    <p class="card-text">Track your recent orders and view your order history.</p>
                                    <a href="<?= url_to('account_orders') ?>" class="btn btn-primary btn-sm">View Orders</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-heart me-2"></i>My Wishlist</h5>
                                    <p class="card-text">Browse items you've saved for later.</p>
                                    <a href="<?= url_to('account_wishlist') ?>" class="btn btn-primary btn-sm">View Wishlist</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('msg_success')): ?>
                        <div class="alert alert-success mt-3"><?= session()->getFlashdata('msg_success') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>