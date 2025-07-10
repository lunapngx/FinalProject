<?= view('Customer/header') ?>

    <div class="container d-flex justify-content-between mt-4">
        <!-- Sidebar/Profile -->
        <div class="profile-box p-3" style="width: 250px; border: 1px solid #ccc;">
            <div class="text-center">
                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="rounded-circle" width="100" height="100">
                <h5 class="mt-2">Gian Rich Antonio Mostajo</h5>
                <span style="color: green;">● Online</span>
            </div>
            <hr>
            <div>
                <p><strong style="background-color: #eee; padding: 5px; border-radius: 5px;">🛒 CART</strong></p>
                <p><strong>♡ WISHLIST</strong></p>
                <p><strong>MY ORDERS</strong></p>
            </div>
        </div>

        <!-- Cart Content -->
        <div class="wishlist-box p-3" style="width: 75%; border: 1px solid #ccc;">
            <div class="row">
                <!-- Cart Table (Left) -->
                <div class="col-md-8">
                    <h4 class="fw-bold mb-3">MY CART</h4>
                    <table class="table table-borderless bg-light rounded shadow-sm">
                        <thead class="fw-bold border-bottom">
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>QTY</th>
                            <th class="text-end">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Cart Items -->
                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('images/cart1.jpg') ?>" width="60" class="me-2 rounded" alt="Product">
                                    <div>
                                        <small>Color: Blue<br>Size: L</small><br>
                                        <i class="bi bi-trash text-danger"></i>
                                    </div>
                                </div>
                            </td>
                            <td>₱ 150</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-dark btn-sm">−</button>
                                    <span class="mx-2">1</span>
                                    <button class="btn btn-outline-dark btn-sm">+</button>
                                </div>
                            </td>
                            <td class="text-end">₱ 150</td>
                        </tr>

                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('images/cart2.jpg') ?>" width="60" class="me-2 rounded" alt="Product">
                                    <div>
                                        <small>Color: Pink<br>Size: M</small><br>
                                        <i class="bi bi-trash text-danger"></i>
                                    </div>
                                </div>
                            </td>
                            <td>₱ 250</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-dark btn-sm">−</button>
                                    <span class="mx-2">2</span>
                                    <button class="btn btn-outline-dark btn-sm">+</button>
                                </div>
                            </td>
                            <td class="text-end">₱ 500</td>
                        </tr>

                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('images/cart3.jpg') ?>" width="60" class="me-2 rounded" alt="Product">
                                    <div>
                                        <small>Color: Red<br>Size: S</small><br>
                                        <i class="bi bi-trash text-danger"></i>
                                    </div>
                                </div>
                            </td>
                            <td>₱ 200</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-dark btn-sm">−</button>
                                    <span class="mx-2">3</span>
                                    <button class="btn btn-outline-dark btn-sm">+</button>
                                </div>
                            </td>
                            <td class="text-end">₱ 600</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-dark me-2">UPDATE</button>
                        <button class="btn btn-outline-danger">DELETE</button>
                    </div>
                </div>

                <!-- Order Summary (Right) -->
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded shadow-sm">
                        <h5 class="fw-bold mb-3">ORDER SUMMARY</h5>
                        <p class="d-flex justify-content-between">
                            <span>Subtotal</span> <span>₱1,250</span>
                        </p>
                        <p>Shipping</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping" id="delivery" checked>
                            <label class="form-check-label" for="delivery">Standard Delivery - ₱40</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping" id="pickup">
                            <label class="form-check-label" for="pickup">Self Pick-Up - ₱0</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping" id="free">
                            <label class="form-check-label" for="free">Free Shipping (Orders over ₱300)</label>
                        </div>
                        <p class="d-flex justify-content-between">
                            <span>Discount</span> <span>-₱0.00</span>
                        </p>
                        <hr>
                        <h5 class="d-flex justify-content-between fw-bold">
                            <span>TOTAL</span> <span>₱1,250.00</span>
                        </h5>
                        <button class="btn btn-dark w-100 mt-3">PROCEED TO CHECKOUT →</button>
                        <a href="<?= base_url('products') ?>" class="btn btn-outline-secondary w-100 mt-2">← Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= view('Customer/footer') ?>