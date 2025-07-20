<?= $this->extend('layouts/admin_master') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Product</h1>
                    </div><div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= url_to('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= url_to('admin_products') ?>">Products</a></li> <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div></div></div></div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Product Details</h3>
                            </div>
                            <?= form_open_multipart(url_to('admin_save_product')) ?> <?= csrf_field() ?> <div class="card-body">
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <input type="hidden" name="id" value="<?= esc($product['id']) ?>">

                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $product['name']) ?>" placeholder="Enter product name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description"><?= old('description', $product['description']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="<?= old('price', $product['price']) ?>" step="0.01" placeholder="Enter price">
                                </div>
                                <div class="form-group">
                                    <label for="original_price">Original Price (Optional)</label>
                                    <input type="number" class="form-control" id="original_price" name="original_price" value="<?= old('original_price', $product['original_price']) ?>" step="0.01" placeholder="Enter original price">
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock Quantity</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $product['stock']) ?>" placeholder="Enter stock quantity">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select a Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= esc($category['id']) ?>" <?= (old('category_id', $product['category_id']) == $category['id']) ? 'selected' : '' ?>>
                                                <?= esc($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_image">Product Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="product_image" name="product_image">
                                            <label class="custom-file-label" for="product_image">Choose file</label>
                                        </div>
                                    </div>
                                    <?php if ($product['image']): ?>
                                        <small class="form-text text-muted mt-2">Current Image:</small>
                                        <img src="<?= base_url($product['image']) ?>" alt="Current Product Image" class="img-thumbnail mt-2" style="max-width: 150px; border-radius: 8px;">
                                    <?php endif; ?>
                                    <?php if (session('errors.product_image')) : ?>
                                        <div class="text-danger text-sm mt-1"><?= session('errors.product_image') ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="colors">Colors (comma-separated)</label>
                                    <input type="text" class="form-control" id="colors" name="colors" value="<?= old('colors', $product['colors']) ?>" placeholder="e.g., Red, Blue, Green">
                                </div>
                                <div class="form-group">
                                    <label for="sizes">Sizes (comma-separated)</label>
                                    <input type="text" class="form-control" id="sizes" name="sizes" value="<?= old('sizes', $product['sizes']) ?>" placeholder="e.g., S, M, L, XL">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div></section>
    </div>
<?= $this->endSection() ?>