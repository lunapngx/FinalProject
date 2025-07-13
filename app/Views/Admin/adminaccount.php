<?= $this->extend('Layout/admin_master') ?>

<?= $this->section('title') ?>Admin Account<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container admin-dashboard-page">
        <div class="admin-header-nav mb-4 bg-white py-3 shadow-sm rounded-bottom">
            <div class="container d-flex justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_dashboard') ?>">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_products') ?>">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_orders') ?>">ORDERS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_sales_report') ?>">SALES REPORT</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= url_to('admin_account') ?>">ADMIN ACCOUNT</a></li>
                </ul>
            </div>
        </div>

        <h2>Admin Account Settings</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Admin Profile Information</h5>
                <p><strong>Username:</strong> <?= session()->get('admin_username') ?></p>
                <p><strong>Full Name:</strong> <?= session()->get('admin_fullname') ?></p>
                <hr>
                <h5 class="card-title mb-3">Change Password</h5>
                <form action="/admin/update-password" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>