<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>Your Cart<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/cart.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="cart-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-start fw-bold mb-0">CART</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>


        <?php foreach (['success', 'error', 'info'] as $msg): ?>
            <?php if (session()->getFlashdata($msg)): ?>
                <div class="alert alert-<?= $msg ?> alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="cart-grid">
            <div class="cart-items">
                <table>
                    <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="product-info-cell">
                                        <img src="<?= base_url('public/assets/img/' . esc($item->product['image'])) ?>"
                                             alt="<?= esc($item->product['name']) ?>" class="product-image-small">
                                        <div>
                                            <strong><?= esc($item->product['name']) ?></strong><br>
                                            <?php if (!empty($item->options)): ?>
                                                <?php foreach($item->options as $key => $value): ?>
                                                    <small class="badge bg-light text-dark"><?= ucfirst($key) ?>: <?= esc($value) ?></small>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <form action="<?= url_to('cart_remove') ?>" method="post" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="product_id" value="<?= esc($item->product['id']) ?>">
                                                <button type="submit" class="btn-remove-link">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>₱<?= number_format($item->product['price'], 2) ?></td>
                                <td>
                                    <form action="<?= url_to('cart_update') ?>" method="post" class="quantity-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= esc($item->product['id']) ?>">
                                        <div class="quantity-controls">
                                            <button type="button" class="btn-minus">−</button>
                                            <input type="number" name="quantity" value="<?= esc($item->quantity) ?>" min="1" max="<?= esc($item->product['stock'] ?? 99) ?>">
                                            <button type="button" class="btn-plus">+</button>
                                        </div>
                                        <button type="submit" class="d-none update-item-btn"></button>
                                    </form>
                                </td>
                                <td>₱<?= number_format($item->itemTotal, 2) ?></td>
                                <td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <div class="cart-bottom-actions">
                    <div class="coupon-section">
                        <input type="text" placeholder="Coupon code">
                        <button class="btn-apply-coupon">Apply</button>
                    </div>
                    <div class="update-clear-buttons">
                        <button class="btn-update-cart d-none">Update Cart</button> <form action="" method="post" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="clear_cart" value="1">
                            <button type="submit" class="btn-clear-cart">Clear Cart</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h3 class="fw-bold text-center">ORDER SUMMARY</h3>
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span id="subtotal">₱<?= number_format($total, 2) ?></span>
                </div>
                <div class="summary-line shipping-options">
                    <span>Shipping</span>
                    <div class="shipping-radio-group">
                        <label>
                            <input type="radio" name="shipping_method" value="standard" checked> Standard Delivery – ₱40
                        </label>
                        <label>
                            <input type="radio" name="shipping_method" value="express"> Express Delivery – ₱120
                        </label>
                        <label>
                            <input type="radio" name="shipping_method" value="free"> Free Shipping (Orders over ₱300)
                        </label>
                    </div>
                </div>
                <div class="summary-line">
                    <span>Tax</span>
                    <span id="tax">₱27.00</span> </div>
                <div class="summary-line">
                    <span>Discount</span>
                    <span id="discount">-₱0.00</span> </div>
                <div class="summary-line total">
                    <span>TOTAL</span>
                    <span id="grandTotal">₱<?= number_format($total + 40 + 27, 2) ?></span> </div>
                <a href="<?= url_to('checkout_view') ?>" class="btn btn-proceed">PROCEED TO CHECKOUT →</a>
                <a href="<?= url_to('products_list') ?>" class="btn btn-continue">← Continue Shopping</a>
                <div class="secure-checkout mt-3 text-center">
                    🔒 Secure Checkout
                    <div class="payment-methods">
                        <i class="bi bi-credit-card-fill"></i>
                        <i class="bi bi-bank"></i>
                        <i class="bi bi-paypal"></i>
                        <i class="bi bi-apple-pay"></i>
                        <i class="bi bi-google-play"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Custom Script for Bootstrap Alert Dismissal (since full BS JS is removed) ---
            document.querySelectorAll('.alert .btn-close').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.alert').style.display = 'none';
                });
            });
            // --- End of Alert Dismissal Script ---


            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax'); // Assuming fixed tax
            const discountEl = document.getElementById('discount'); // Assuming fixed discount
            const totalEl = document.getElementById('grandTotal');
            const shippingRad = document.querySelectorAll('input[name="shipping_method"]');

            // Helper to parse currency string to float
            const parsePeso = txt => parseFloat(txt.replace(/[₱,]/g, '')) || 0;
            // Helper to format float to currency string
            const fmtPeso = num => '₱' + num.toFixed(2);

            // Get initial subtotal from the displayed value (will be passed from PHP)
            let baseSubtotal = parsePeso(subtotalEl.textContent);
            let currentTax = parsePeso(taxEl.textContent);
            let currentDiscount = parsePeso(discountEl.textContent); // This will likely be negative or 0

            const updateGrandTotal = () => {
                let shipCost = 0;
                const selectedShipping = document.querySelector('input[name="shipping_method"]:checked').value;

                switch(selectedShipping) {
                    case 'standard': shipCost = 40; break;
                    case 'express': shipCost = 120; break;
                    case 'free': shipCost = baseSubtotal >= 300 ? 0 : 40; break; // Assume standard if not free
                }

                const grandTotal = baseSubtotal + shipCost + currentTax + currentDiscount;
                totalEl.textContent = fmtPeso(grandTotal);
            };

            // Event listeners for shipping radios
            shippingRad.forEach(radio => {
                radio.addEventListener('change', updateGrandTotal);
            });

            // Initial calculation on page load
            updateGrandTotal();

            document.querySelectorAll('.quantity-form').forEach(form => {
                const input = form.querySelector('input[name="quantity"]');
                const minus = form.querySelector('.btn-minus');
                const plus = form.querySelector('.btn-plus');
                const updateBtn = form.querySelector('.update-item-btn'); // The hidden submit button

                minus.addEventListener('click', () => {
                    let val = parseInt(input.value);
                    if (val > parseInt(input.min)) {
                        input.value = val - 1;
                        updateBtn.click(); // Trigger form submission
                    }
                });

                plus.addEventListener('click', () => {
                    let val = parseInt(input.value);
                    // The max attribute is already handled by the server-side validation
                    // but we can add a client-side check for immediate feedback
                    if (val < parseInt(input.max)) {
                        input.value = val + 1;
                        updateBtn.click(); // Trigger form submission
                    }
                });

                input.addEventListener('change', () => {
                    let val = parseInt(input.value);
                    const min = parseInt(input.min);
                    const max = parseInt(input.max);
                    // Ensure value is within min/max bounds
                    input.value = Math.max(min, Math.min(max, isNaN(val) ? min : val));
                    updateBtn.click(); // Trigger form submission
                });
            });
        });
    </script>
<?= $this->endSection() ?>