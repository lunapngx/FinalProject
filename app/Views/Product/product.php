<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= /** @var TYPE_NAME $product */
esc($product['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section id="product-details" class="product-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-5">

                <div class="col-lg-6">
                    <div class="product-images">
                        <div class="main-image-container">
                            <div class="image-zoom-container">
                                <img id="main-Product-image"
                                     src="<?= base_url('assets/img/' . esc($product['image'])) ?>"
                                     data-zoom="<?= base_url('assets/img/' . esc($product['image'])) ?>"
                                     class="img-fluid main-image" alt="<?= esc($product['name']) ?>">
                            </div>
                        </div>
                        <div class="product-thumbnails swiper init-swiper">
                            <div class="swiper-wrapper">
                                <?php
                                // Placeholder for thumbnails. If you have multiple images for a product,
                                // your ProductModel and Controller should provide an array, e.g., $product['gallery_images'].
                                // For now, it uses the main image as a placeholder thumbnail.
                                $thumbnails = [$product['image']];
                                // Example if $product['gallery_images'] existed:
                                // if (!empty($product['gallery_images']) && is_array($product['gallery_images'])) {
                                //     $thumbnails = array_merge([$product['image']], $product['gallery_images']);
                                // }
                                ?>
                                <?php foreach ($thumbnails as $thumb_img): ?>
                                    <div class="swiper-slide thumbnail-item <?= ($thumb_img === $product['image']) ? 'active' : '' ?>"
                                         data-image="<?= base_url('assets/img/' . esc($thumb_img)) ?>">
                                        <img src="<?= base_url('assets/img/' . esc($thumb_img)) ?>" class="img-fluid"
                                             alt="Thumbnail">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product-info">
                        <div class="product-meta d-flex justify-content-between align-items-center">
                            <span class="product-category text-uppercase"><?= esc($product['category_name'] ?? 'Uncategorized') ?></span>
                            <div class="product-rating">
                                <?php
                                // Placeholder for average rating. You'd calculate this from your reviews.
                                $averageRating = 4.5;
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($averageRating >= $i) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($averageRating > ($i - 1)) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                                <span class="rating-count">(<?= count($reviews ?? []) ?> Reviews)</span>
                            </div>
                        </div>

                        <h1 class="product-title"><?= esc($product['name']) ?></h1>

                        <div class="product-price-container d-flex align-items-center">
                            <span class="current-price">$<?= esc(number_format($product['price'], 2)) ?></span>
                            <?php if (isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                <span class="original-price">$<?= esc(number_format($product['original_price'], 2)) ?></span>
                                <span class="discount-badge">-<?= esc(round((($product['original_price'] - $product['price']) / $product['original_price']) * 100)) ?>%</span>
                            <?php endif; ?>
                        </div>

                        <p class="product-short-description">
                            <?= nl2br(esc($product['description'])) ?>
                        </p>

                        <div class="product-availability d-flex align-items-center mb-3">
                            <?php if (isset($product['stock']) && $product['stock'] > 0): ?>
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="text-success">In Stock</span>
                                <span class="stock-count">(<?= esc($product['stock']) ?> items left)</span>
                            <?php else: ?>
                                <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                <span class="text-danger">Out of Stock</span>
                            <?php endif; ?>
                        </div>

                        <form action="<?= url_to('cart_add') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">

                            <?php if (!empty($product['colors'])): ?>
                                <div class="product-colors mb-4">
                                    <h4 class="option-title">Color: <span class="selected-option"
                                                                          id="selected-color"><?= esc($product['colors'][0] ?? '') ?></span>
                                    </h4>
                                    <div class="color-options d-flex">
                                        <?php foreach ($product['colors'] as $c): ?>
                                            <label class="color-option me-2" style="background-color: <?= esc($c) ?>;">
                                                <input type="radio" name="color"
                                                       value="<?= esc($c) ?>" <?= (isset($product['colors'][0]) && $c === $product['colors'][0]) ? 'checked' : '' ?>
                                                       required>
                                                <i class="bi bi-check-circle-fill"></i>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($product['sizes'])): ?>
                                <div class="product-sizes mb-4">
                                    <h4 class="option-title">Size: <span class="selected-option"
                                                                         id="selected-size"><?= esc($product['sizes'][0] ?? '') ?></span>
                                    </h4>
                                    <div class="size-options d-flex">
                                        <?php foreach ($product['sizes'] as $s): ?>
                                            <label class="size-option me-2">
                                                <input type="radio" name="size"
                                                       value="<?= esc($s) ?>" <?= (isset($product['sizes'][0]) && $s === $product['sizes'][0]) ? 'checked' : '' ?>
                                                       required>
                                                <span><?= esc($s) ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="product-quantity mb-4">
                                <h4 class="option-title">Quantity:</h4>
                                <div class="quantity-selector d-flex align-items-center">
                                    <button type="button" class="quantity-btn decrease">-</button>
                                    <input type="number" name="quantity" value="1" min="1"
                                           max="<?= esc($product['stock'] ?? 99) ?>"
                                           class="form-control quantity-input">
                                    <button type="button" class="quantity-btn increase">+</button>
                                </div>
                            </div>

                            <div class="product-actions d-flex align-items-center mb-4">
                                <button type="submit" class="btn btn-primary add-to-cart-btn flex-fill me-3">
                                    <i class="bi bi-bag-plus me-2"></i>Add to Cart
                                </button>
                                <button type="submit" formaction="<?= url_to('order_place') ?>"
                                        class="btn btn-outline-primary buy-now-btn flex-fill me-3">
                                    <i class="bi bi-lightning-charge me-2"></i>Buy Now
                                </button>
                                <button type="button" class="btn btn-outline-secondary wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </form>

                        <div class="additional-info pt-4 mt-4">
                            <div class="info-item d-flex align-items-center mb-2">
                                <i class="bi bi-truck me-2"></i>
                                <span>Free Shipping on orders over $50</span>
                            </div>
                            <div class="info-item d-flex align-items-center mb-2">
                                <i class="bi bi-arrow-return-left me-2"></i>
                                <span>30-day return policy</span>
                            </div>
                            <div class="info-item d-flex align-items-center">
                                <i class="bi bi-shield-check me-2"></i>
                                <span>2-year warranty</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="product-details-tabs mt-5">
                <ul class="nav nav-tabs justify-content-center" id="productDetailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab"
                                data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications"
                                aria-selected="false">Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews
                            (<?= count($reviews ?? []) ?>)
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="productDetailTabsContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                         aria-labelledby="description-tab">
                        <h4 class="mt-4">Product Overview</h4>
                        <p><?= nl2br(esc($product['description'])) ?></p>
                        <h4 class="mt-4">Key Features</h4>
                        <ul>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>
                            <li>Vestibulum at lacus congue, suscipit elit nec, tincidunt orci</li>
                            <li>Phasellus egestas nisi vitae lectus imperdiet venenatis</li>
                            <li>Suspendisse vulputate quam diam, et consectetur augue condimentum in</li>
                            <li>Aenean dapibus ipsum eget nisi pharetra, in iaculis nulla blandit</li>
                        </ul>
                        <h4 class="mt-4">What's in the Box</h4>
                        <ul>
                            <li>Lorem Ipsum Wireless Headphones</li>
                            <li>Carrying Cable</li>
                            <li>USB-C Charging Cable</li>
                            <li>3.5mm Audio Cable</li>
                            <li>User Manual</li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                        <h4 class="mt-4">Technical Specifications</h4>
                        <div class="specs-table">
                            <div class="specs-row">
                                <span class="specs-label">Weight</span>
                                <span class="specs-value">300g</span>
                            </div>
                            <div class="specs-row">
                                <span class="specs-label">Dimensions</span>
                                <span class="specs-value">15cm x 10cm x 5cm</span>
                            </div>
                            <div class="specs-row">
                                <span class="specs-label">Material</span>
                                <span class="specs-value">Leather, Metal, Fabric</span>
                            </div>
                            <div class="specs-row">
                                <span class="specs-label">Connectivity</span>
                                <span class="specs-value">Bluetooth 5.0, USB-C, 3.5mm Jack</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <h4 class="mt-4">Customer Reviews</h4>
                        <div class="reviews-summary d-flex align-items-center justify-content-center">
                            <div class="overall-rating text-center">
                                <span class="rating-number">4.5</span>
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-half"></i>
                                </div>
                                <span class="rating-count">(<?= count($reviews ?? []) ?> Reviews)</span>
                            </div>
                            <div class="rating-breakdown ps-lg-5">
                                <div class="rating-bar d-flex align-items-center">
                                    <span class="rating-label">5 Stars</span>
                                    <div class="progress flex-fill mx-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%;"
                                             aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-count">80%</span>
                                </div>
                                <div class="rating-bar d-flex align-items-center">
                                    <span class="rating-label">4 Stars</span>
                                    <div class="progress flex-fill mx-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: 10%;"
                                             aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-count">10%</span>
                                </div>
                                <div class="rating-bar d-flex align-items-center">
                                    <span class="rating-label">3 Stars</span>
                                    <div class="progress flex-fill mx-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: 5%;"
                                             aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-count">5%</span>
                                </div>
                                <div class="rating-bar d-flex align-items-center">
                                    <span class="rating-label">2 Stars</span>
                                    <div class="progress flex-fill mx-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: 3%;"
                                             aria-valuenow="3" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-count">3%</span>
                                </div>
                                <div class="rating-bar d-flex align-items-center">
                                    <span class="rating-label">1 Star</span>
                                    <div class="progress flex-fill mx-3" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: 2%;"
                                             aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="rating-count">2%</span>
                                </div>
                            </div>
                        </div>

                        <div class="review-form-container bg-light p-4 rounded mb-5">
                            <h4 class="text-center mb-4">Leave a Review</h4>
                            <form action="#" method="post">
                                <div class="mb-3">
                                    <label for="reviewerName" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="reviewerName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reviewerEmail" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="reviewerEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reviewRating" class="form-label">Your Rating</label>
                                    <div class="star-rating d-flex justify-content-center">
                                        <input type="radio" id="star5" name="rating" value="5"/><label for="star5"
                                                                                                       title="5 stars"><i
                                                class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4"/><label for="star4"
                                                                                                       title="4 stars"><i
                                                class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3"/><label for="star3"
                                                                                                       title="3 stars"><i
                                                class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2"/><label for="star2"
                                                                                                       title="2 stars"><i
                                                class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1"/><label for="star1"
                                                                                                       title="1 star"><i
                                                class="bi bi-star-fill"></i></label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reviewComment" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="reviewComment" rows="4" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>

                        <div class="reviews-list">
                            <?php if (!empty($reviews)): ?>
                                <?php foreach ($reviews as $r): ?>
                                    <div class="review-item bg-white p-4 rounded shadow-sm mb-3">
                                        <div class="review-header d-flex justify-content-between align-items-start mb-2">
                                            <div class="reviewer-info d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="User Avatar"
                                                     class="reviewer-avatar rounded-circle me-3">
                                                <div>
                                                    <h5 class="reviewer-name mb-0"><?= esc($r['user_name']) ?></h5>
                                                    <span class="review-date text-muted"><?= date('F j, Y', strtotime($r['created_at'])) ?></span>
                                                </div>
                                            </div>
                                            <div class="review-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($r['rating'] >= $i): ?>
                                                        <i class="bi bi-star-fill"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-star"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <h6 class="review-title mb-2">Great Product!</h6>
                                        <div class="review-content">
                                            <p><?= esc($r['comment']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center">No reviews yet. Be the first to review this product!</p>
                            <?php endif; ?>
                            <div class="text-center mt-4">
                                <button class="btn btn-outline-primary load-more-btn">Load More Reviews</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>