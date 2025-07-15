<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">LOGIN</h5>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= esc($error) ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= esc(session('errors')) ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <?php if (session('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= esc(session('message')) ?></div>
                <?php endif ?>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email / Username</label>
                        <input type="text" class="form-control <?php if (session('errors.email') || session('errors.username')) : ?>is-invalid<?php endif ?>"
                               id="email" name="email" inputmode="email" autocomplete="email"
                               placeholder="Email or Username" value="<?= old('email') ?>" required>
                        <?php if (session('errors.email')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.email')) ?>
                            </div>
                        <?php endif ?>
                        <?php if (session('errors.username')) : // Fallback for username if applicable ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.username')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                               id="password" name="password" inputmode="text" autocomplete="current-password"
                               placeholder="Password" required>
                        <?php if (session('errors.password')) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors.password')) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember" <?php if (old('remember')): ?> checked<?php endif ?>>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        <?php endif; ?>

                        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                            <a href="<?= url_to('magic-link') ?>" class="small">Forgot Password?</a>
                        <?php elseif (setting('Auth.allowPasswordReset')) : ?>
                            <a href="<?= url_to('forgot') ?>" class="small">Forgot Password?</a>
                        <?php endif ?>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                    </div>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="text-center">
                            Don't have an account? <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
                        </p>
                    <?php endif ?>

                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>