<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">SIGN UP</h5>

                <?php if (session('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= esc(session('message')) ?></div>
                <?php endif ?>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php // var_dump(session('errors')); // TEMPORARY DEBUGGING LINE - REMOVE IN PRODUCTION ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= esc($error) ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= esc(session('errors')) ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control <?php if (session('errors.first_name')) : ?>is-invalid<?php endif ?>"
                               name="first_name" id="first_name" inputmode="text" autocomplete="given-name"
                               placeholder="First Name" value="<?= old('first_name') ?>" required>
                        <?php if (session('errors.first_name')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.first_name')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control <?php if (session('errors.last_name')) : ?>is-invalid<?php endif ?>"
                               name="last_name" id="last_name" inputmode="text" autocomplete="family-name"
                               placeholder="Last Name" value="<?= old('last_name') ?>" required>
                        <?php if (session('errors.last_name')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.last_name')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                               name="username" id="username" inputmode="text" autocomplete="username"
                               placeholder="Username" value="<?= old('username') ?>" required>
                        <?php if (session('errors.username')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.username')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                               name="email" id="email" inputmode="email" autocomplete="email"
                               placeholder="Email" value="<?= old('email') ?>" required>
                        <?php if (session('errors.email')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.email')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                               name="password" id="password" inputmode="text" autocomplete="new-password"
                               placeholder="Password" required>
                        <?php if (session('errors.password')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.password')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?php if (session('errors.password_confirm')) : ?>is-invalid<?php endif ?>"
                               name="password_confirm" id="password_confirm" inputmode="text" autocomplete="new-password"
                               placeholder="Confirm Password" required>
                        <?php if (session('errors.password_confirm')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.password_confirm')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </div>

                    <p class="text-center mt-3">
                        Already registered? <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a>
                    </p>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>