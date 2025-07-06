<?= $this->extend('Layout/master') ?>

<?= $this->section('title') ?>Checkout<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="checkout-container">
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

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

        <div class="left">
            <?= form_open(url_to('checkout_process')) ?><?= csrf_field() ?>

            <h3>1. Customer Information</h3>
            <input type="text" name="first_name" placeholder="First Name" value="<?= set_value('first_name') ?>"
                   required><br><br>
            <input type="text" name="last_name" placeholder="Last Name" value="<?= set_value('last_name') ?>"
                   required><br><br>
            <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" required><br><br>
            <input type="text" name="phone" placeholder="Phone" value="<?= set_value('phone') ?>" required><br><br>

            <h3>2. Shipping Address</h3>
            <input type="text" name="street" placeholder="Street Address" value="<?= set_value('street') ?>"
                   required><br><br>
            <input type="text" name="apartment" placeholder="Apt, Suite, etc. (opt)"
                   value="<?= set_value('apartment') ?>"><br><br>
            <input type="text" name="city" placeholder="City" value="<?= set_value('city') ?>" required><br><br>
            <input type="text" name="state" placeholder="State" value="<?= set_value('state') ?>" required><br><br>
            <input type="text" name="zip" placeholder="ZIP Code" value="<?= set_value('zip') ?>" required><br><br>
            <input type="text" name="country" placeholder="Country" value="<?= set_value('country') ?: 'Philippines' ?>"
                   required><br><br>


            <h3>3. Payment Method</h3>
            <label>
                <input type="radio" name="payment_method" value="cod"
                    <?= set_radio('payment_method', 'cod', true) ?>>
                Cash on Delivery
            </label><br><br>

            <label>
                <input type="radio" name="payment_method" value="pickup"
                    <?= set_radio('payment_method', 'pickup') ?>>
                Pick Up
            </label><br><br>

            <button type="submit">Place Order</button>
            <?= form_close() ?>
        </div>

        <div class="right order-summary">
            <h3>Order Summary <small>(<?= count($items) ?> Items)</small></h3>

            <?php foreach ($items as $it): ?>
                <div class="item" style="display:flex; gap:.5rem; margin-bottom:1rem;">
                    <img src="<?= esc($it['thumb'] ?? base_url('public/assets/img/product/product-placeholder.jpg')) ?>"
                         width="60" alt="<?= esc($it['name']) ?>">
                    <div class="details" style="flex:1;">
                        <strong><?= esc($it['name']) ?></strong><br>
                        <?php if (isset($it['options'])): ?>
                            <small>
                                <?php foreach ($it['options'] as $key => $value): ?>
                                    <?= esc(ucfirst($key)) ?>: <?= esc($value) ?> |
                                <?php endforeach; ?>
                            </small><br>
                        <?php endif; ?>
                        <span><?= $it['qty'] ?> × <?= number_to_currency($it['price'], 'PHP') ?></span>
                    </div>
                </div>
                <hr>
            <?php endforeach ?>

            <div class="promo" style="display:flex; gap:.5rem; margin:1rem 0;">
                <input type="text" name="promo_code" placeholder="Promo Code">
                <button type="button">Apply</button>
            </div>

            <div class="totals">
                <div style="display:flex;justify-content:space-between">
                    <span>Subtotal</span><span><?= number_to_currency($subtotal, 'PHP') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span>Shipping</span><span><?= number_to_currency($shipping, 'PHP') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span>Tax</span><span><?= number_to_currency($tax, 'PHP') ?></span>
                </div>
                <hr style="border:0;border-top:1px dotted #ccc;">
                <div style="display:flex;justify-content:space-between;font-size:1.1rem">
                    <strong>Total</strong><strong><?= number_to_currency($total, 'PHP') ?></strong>
                </div>
            </div>

            <div class="secure" style="text-align:center;margin-top:1rem;font-size:.9rem">
                🔒 Secure Checkout
                <div class="icons" style="font-size:1.5rem;margin-top:.5rem">
                    💳 🏦 🅿️ 🍎
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>9
    <script>
        // any JS you need just on this page
    </script>
<?= $this->endSection() ?>