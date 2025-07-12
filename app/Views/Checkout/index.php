<?= $this->extend('Layout/master') ?>
<?= $this->section('title') ?>Checkout<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="checkout-container row my-5">

    <!-- LEFT: Checkout Form -->
    <div class="col-md-7">
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?= form_open(route_to('checkout_process')) ?>
        <?= csrf_field() ?>

        <h4>1. Customer Information</h4>
        <div class="mb-2">
            <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?= set_value('first_name') ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?= set_value('last_name') ?>" required>
        </div>
        <div class="mb-2">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>" required>
        </div>
        <div class="mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= set_value('phone') ?>" required>
        </div>

        <h4>2. Shipping Address</h4>
        <div class="mb-2">
            <input type="text" name="street" class="form-control" placeholder="Street Address" value="<?= set_value('street') ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="apartment" class="form-control" placeholder="Apartment (optional)" value="<?= set_value('apartment') ?>">
        </div>
        <div class="mb-2">
            <input type="text" name="city" class="form-control" placeholder="City" value="<?= set_value('city') ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="state" class="form-control" placeholder="State" value="<?= set_value('state') ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="zip" class="form-control" placeholder="ZIP Code" value="<?= set_value('zip') ?>" required>
        </div>
        <div class="mb-3">
            <input type="text" name="country" class="form-control" placeholder="Country" value="<?= set_value('country', 'Philippines') ?>" required>
        </div>

        <h4>3. Payment Method</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="cod" <?= set_radio('payment_method', 'cod', true) ?>>
            <label class="form-check-label">Cash on Delivery</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="payment_method" value="pickup" <?= set_radio('payment_method', 'pickup') ?>>
            <label class="form-check-label">Pick Up</label>
        </div>

        <button type="submit" class="btn btn-dark">Place Order</button>
        <?= form_close() ?>
    </div>

    <!-- RIGHT: Order Summary -->
    <div class="col-md-5">
        <div class="card p-4">
            <h4>Order Summary <small>(<?= count($items) ?> items)</small></h4>
            <hr>

            <?php foreach ($items as $it): ?>
                <div class="d-flex mb-3">
                    <img src="<?= base_url($it['thumb']) ?>" width="60" class="me-3" alt="<?= esc($it['name']) ?>">
                    <div>
                        <strong><?= esc($it['name']) ?></strong><br>
                        <small><?= $it['qty'] ?> × <?= number_to_currency($it['price'], 'PHP') ?></small>
                    </div>
                </div>
            <?php endforeach; ?>

            <hr>

            <div class="mb-3">
                <label>Promo Code</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo Code">
                    <button class="btn btn-outline-secondary" type="button">Apply</button>
                </div>
            </div>

            <div class="d-flex justify-content-between"><span>Subtotal:</span><span><?= number_to_currency($subtotal, 'PHP') ?></span></div>
            <div class="d-flex justify-content-between"><span>Shipping:</span><span><?= number_to_currency($shipping, 'PHP') ?></span></div>
            <div class="d-flex justify-content-between"><span>Tax:</span><span><?= number_to_currency($tax, 'PHP') ?></span></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold"><span>Total:</span><span><?= number_to_currency($total, 'PHP') ?></span></div>
        </div>

        <div class="text-center mt-3 small">
            🔒 Secure Checkout &nbsp; | &nbsp; 💳 🏦 🅿️ 🍎
        </div>
    </div>

</div>

<?= $this->endSection() ?>
