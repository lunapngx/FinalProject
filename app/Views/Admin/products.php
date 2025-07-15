<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/admin.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container admin-dashboard-page">
        <div class="admin-header-nav mb-4 bg-white py-3 shadow-sm rounded-bottom">
            <div class="container d-flex justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_dashboard') ?>">HOME</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= url_to('admin_products') ?>">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_orders') ?>">ORDERS</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_sales_report') ?>">SALES REPORT</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url_to('admin_account') ?>">ADMIN ACCOUNT</a></li>
                </ul>
            </div>
        </div>

        <div class="section-header mb-4">
            <h2>Manage Products</h2>
            <div class="header-actions">
                <a href="<?= url_to('admin_add_product') ?>" class="btn btn-primary">Add New Product</a>
            </div>
        </div>

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
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Colors</th>
                        <th>Sizes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= esc($product['id']) ?></td>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($product['name']) ?></td>
                                <td>₱<?= esc(number_format($product['price'], 2)) ?>
                                    <?php if ($product['original_price'] && $product['original_price'] > $product['price']): ?>
                                        <br><small><del>₱<?= esc(number_format($product['original_price'], 2)) ?></del></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($product['stock']) ?></td>
                                <td><?= esc($product['category_id']) // You might want to fetch category name here ?></td>
                                <td>
                                    <?php
                                    // Assuming colors is an array due to afterFind callback
                                    if (is_array($product['colors']) && !empty($product['colors'])) {
                                        echo implode(', ', $product['colors']);
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Assuming sizes is an array due to afterFind callback
                                    if (is_array($product['sizes']) && !empty($product['sizes'])) {
                                        echo implode(', ', $product['sizes']);
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= url_to('admin_edit_product', $product['id']) ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="<?= url_to('admin_products_delete', $product['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>