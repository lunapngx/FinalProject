<?= $this->extend('Layout/master') ?>
<?= $this->section('title') ?>Your Wishlist<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<<<<<<< HEAD
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container d-flex justify-content-between mt-4">
        <!-- Sidebar/Profile -->
        <div class="profile-box p-3 text-center" style="width: 250px; border: 1px solid #ccc; background-color: #f8f9fa;">
            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle mb-2" width="100" height="100">
            <h5 class="mb-1">Gian Rich Antonio Mostajo</h5>
            <span class="text-success">● Online</span>
            <hr>
            <div class="text-start">
                <p><strong>MY ORDERS</strong></p>
                <p><button class="btn btn-outline-dark w-100 mb-2">♡ WISHLIST</button></p>
                <p><strong>MY REVIEWS</strong></p>
            </div>
        </div>

        <!-- Wishlist Section -->
        <div class="wishlist-box p-4" style="width: 75%; border: 1px solid #ccc; background-color: #f3f4f6;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">MY WISHLIST</h4>
                <?php if (!empty($wishlistItems)): ?>
                    <form action="<?= base_url('wishlist/addAllToCart') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-dark">ADD ALL TO CART</button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (!empty($wishlistItems)): ?>
                <div class="row">
                    <?php foreach ($wishlistItems as $item): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100 text-center">
                                <img src="<?= base_url('images/' . $item->product['image']) ?>" class="card-img-top p-3" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title mb-2"><?= esc($item->product['name']) ?></h6>
                                    <p class="text-muted mb-2">₱<?= number_format($item->product['price'], 2) ?></p>
                                    <form action="<?= base_url('wishlist/addToCart') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $item->product['id'] ?>">
                                        <button type="submit" class="btn btn-dark w-100">ADD TO CART</button>
                                    </form>
                                    <form action="<?= base_url('wishlist/remove') ?>" method="post" class="mt-2">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= $item->product['id'] ?>">
                                        <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i> Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">Your wishlist is currently empty.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
=======
<link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-between mt-4">
    <!-- Sidebar/Profile -->
    <div class="profile-box p-3 text-center" style="width: 250px; border: 1px solid #ccc; background-color: #f8f9fa;">
        <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle mb-2" width="100" height="100">
        <h5 class="mb-1">Gian Rich Antonio Mostajo</h5>
        <span class="text-success">● Online</span>
        <hr>
        <div class="text-start">
            <p><strong>MY ORDERS</strong></p>
            <p><button class="btn btn-outline-dark w-100 mb-2">♡ WISHLIST</button></p>
            <p><strong>MY REVIEWS</strong></p>
        </div>
    </div>

    <!-- Wishlist Section -->
    <div class="wishlist-box p-4" style="width: 75%; border: 1px solid #ccc; background-color: #f3f4f6;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">MY WISHLIST</h4>
            <?php if (!empty($wishlistItems)): ?>
                <form action="<?= base_url('wishlist/addAllToCart') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-dark">ADD ALL TO CART</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info"><?= session()->getFlashdata('info') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($wishlistItems)): ?>
            <div class="row">
                <?php foreach ($wishlistItems as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 h-100 text-center">
                            <img src="<?= base_url('images/' . $item->product['image']) ?>" class="card-img-top p-3" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title mb-2"><?= esc($item->product['name']) ?></h6>
                                <p class="text-muted mb-2">₱<?= number_format($item->product['price'], 2) ?></p>
                                <form action="<?= base_url('wishlist/addToCart') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $item->product['id'] ?>">
                                    <button type="submit" class="btn btn-dark w-100">ADD TO CART</button>
                                </form>
                                <form action="<?= base_url('wishlist/remove') ?>" method="post" class="mt-2">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $item->product['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Your wishlist is currently empty.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

>>>>>>> bc956124efcca60068d96b88500acf3a3a46a0aa
