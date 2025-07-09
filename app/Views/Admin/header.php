<header id="admin-header" class="bg-dark text-white py-3 shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a href="/admin/home" class="logo d-flex align-items-center">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Admin Logo" class="me-2" style="height: 40px;">
            <h1 class="fs-4 mb-0 text-white">Admin Panel</h1>
        </a>

        <nav class="admin-nav">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link text-white" href="<?= url_to('admin_dashboard') ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= url_to('admin_products') ?>">Products</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= url_to('admin_orders') ?>">Orders</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= url_to('admin_sales_report') ?>">Sales Report</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= url_to('admin_account') ?>">Admin Account</a></li>
                <li class="nav-item"><a class="nav-link btn btn-outline-light btn-sm ms-3" href="<?= url_to('logout') ?>">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>
