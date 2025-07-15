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

        <h2>Add New Product</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <?= form_open_multipart('/admin/products/add') ?>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('name')) : ?>
                        <div class="text-danger"><?= $validation->getError('name') ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= set_value('description') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('description')) : ?>
                        <div class="text-danger"><?= $validation->getError('description') ?></div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= set_value('price') ?>" required>
                        <?php if (isset($validation) && $validation->hasError('price')) : ?>
                            <div class="text-danger"><?= $validation->getError('price') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="original_price" class="form-label">Original Price (for sale)</label>
                        <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" value="<?= set_value('original_price') ?>">
                        <?php if (isset($validation) && $validation->hasError('original_price')) : ?>
                            <div class="text-danger"><?= $validation->getError('original_price') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= set_value('stock') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('stock')) : ?>
                        <div class="text-danger"><?= $validation->getError('stock') ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category['id']) ?>" <?= set_select('category_id', $category['id']) ?>><?= esc($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('category_id')) : ?>
                        <div class="text-danger"><?= $validation->getError('category_id') ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                    <?php if (isset($validation) && $validation->hasError('image')) : ?>
                        <div class="text-danger"><?= $validation->getError('image') ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="colors" class="form-label">Colors (comma-separated or JSON array)</label>
                    <input type="text" class="form-control" id="colors" name="colors" value="<?= set_value('colors') ?>" placeholder="e.g., Red, Blue, Green or [&quot;Red&quot;,&quot;Blue&quot;]">
                    <?php if (isset($validation) && $validation->hasError('colors')) : ?>
                        <div class="text-danger"><?= $validation->getError('colors') ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="sizes" class="form-label">Sizes (comma-separated or JSON array)</label>
                    <input type="text" class="form-control" id="sizes" name="sizes" value="<?= set_value('sizes') ?>" placeholder="e.g., S, M, L or [&quot;S&quot;,&quot;M&quot;]">
                    <?php if (isset($validation) && $validation->hasError('sizes')) : ?>
                        <div class="text-danger"><?= $validation->getError('sizes') ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
                <a href="<?= url_to('admin_products') ?>" class="btn btn-secondary">Cancel</a>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>