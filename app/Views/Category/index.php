<?php

use App\Models\CategoryModel;

?>
<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>Categories<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container category-page-grid">
        <div class="category-sidebar">
            <h3>Category</h3>
            <nav class="category-list">
                <ul>
                    <?php
                    // Fetch all categories for the sidebar if 'categories' isn't passed from controller
                    // This assumes CategoryModel is available globally or passed
                    $categoryModel = new CategoryModel();
                    $allCategories = $categoryModel->findAll();
                    ?>
                    <?php if (!empty($allCategories)): ?>
                        <?php foreach ($allCategories as $cat): ?>
                            <li>
                                <a href="<?= url_to('products_by_category_slug', $cat['slug'] ?? $cat['id']) ?>">
                                    <?= esc($cat['name']) ?> <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><p>No categories found.</p></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="category-main-content">
            <div class="search-filter-bar">
                <input type="text" placeholder="Search products in this category...">
                <button><i class="bi bi-search"></i></button>
                <select>
                    <option value="">Sort By</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="name-asc">Rose</option>
                </select>
            </div>

            <?php if (isset($products) && !empty($products) && is_array($products)): ?>
                <div class="category-product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="<?= url_to('product_detail', $product['id']) ?>">
                                <div class="product-image">
                                    <img src="<?= base_url('public/assets/img/' . $product['image']) ?>"
                                         alt="<?= esc($product['name']) ?>">
                                </div>
                            </a>
                            <div class="product-info">
                                <h3>
                                    <a href="<?= url_to('product_detail', $product['id']) ?>"><?= esc($product['name']) ?></a>
                                </h3>
                                <p class="price">₱<?= esc(number_format($product['price'], 2)) ?></p>
                                <form action="<?= url_to('cart_add') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No products found in this category.</p>
            <?php endif; ?>

        </div>
    </div>
<?= $this->endSection() ?>