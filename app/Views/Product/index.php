<?= $this->extend('layouts/master') ?>

<?= $this->section('title') ?>All Products<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container product-list-page">
        <h1 class="my-4 text-center">Our Products</h1>

        <?php if (!empty($products) && is_array($products)): ?>
            <div class="row gy-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card">
                            <a href="<?= url_to('product_detail', $product['id']) ?>">
                                <div class="product-image">
                                    <img src="<?= base_url('public/assets/img/' . esc($product['image'])) ?>"
                                         alt="<?= esc($product['name']) ?>">
                                </div>
                            </a>
                            <div class="product-info">
                                <h3><a href="<?= url_to('product_detail', $product['id']) ?>"><?= esc($product['name']) ?></a></h3>
                                <p class="price">₱<?= esc(number_format($product['price'], 2)) ?></p>
                                <form action="<?= url_to('cart_add') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center py-5">No products found.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>