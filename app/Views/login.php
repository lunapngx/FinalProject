<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <style>
        /* Basic styling to match the image's aesthetic - adjust as needed */
        body {
            background-color: #f7f3ed; /* Light beige background */
        }
        .card {
            background-color: #f7f3ed; /* Card background */
            border: none;
            border-radius: 0; /* No rounded corners as per image */
        }
        .card-body {
            padding: 3rem; /* More padding inside the card */
        }
        .card-title {
            color: #4a2e23; /* Dark brown for title */
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem !important; /* Adjust margin as per image */
            text-transform: uppercase;
        }
        .form-floating label {
            color: #4a2e23; /* Dark brown for labels */
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem; /* Smaller font for labels */
            position: absolute;
            top: -1.5rem; /* Position label above input */
            left: 0;
            opacity: 1; /* Make label always visible */
            transform: none; /* Remove floating effect */
            pointer-events: none; /* Make label non-interactive */
        }
        .form-floating > .form-control {
            padding-top: 0.75rem; /* Adjust padding to make space for label */
            padding-bottom: 0.75rem;
        }
        .form-control {
            border-radius: 0;
            border: 1px solid #ccc; /* Light grey border */
            background-color: #ffffff; /* White background for inputs */
            height: 50px; /* Adjust input height */
        }
        .form-control:focus {
            border-color: #4a2e23; /* Dark brown border on focus */
            box-shadow: none; /* Remove default shadow */
        }

        /* Styling for the Remember Me checkbox and Forgot Password link */
        .form-check {
            display: flex;
            align-items: center;
            justify-content: space-between; /* To push Remember Me left and Forgot Password right */
            margin-bottom: 2.5rem; /* Space below this row */
            margin-top: 1rem; /* Space above this row */
        }
        .form-check-label {
            color: #4a2e23; /* Dark brown for Remember me label */
            font-size: 0.9rem;
            font-weight: normal; /* Override bold from other labels */
            margin-bottom: 0; /* Remove default margin */
        }
        .form-check-input {
            margin-right: 0.5rem;
            width: 1.25em; /* Make checkbox slightly larger */
            height: 1.25em;
            border: 1px solid #4a2e23; /* Dark brown border for checkbox */
        }
        .forgot-password-link {
            color: #4a2e23; /* Dark brown for Forgot Password link */
            text-decoration: none; /* No underline by default */
            font-size: 0.9rem;
        }
        .forgot-password-link:hover {
            text-decoration: underline; /* Underline on hover */
        }

        /* Button Styling */
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem; /* Space between the two buttons */
            margin-top: 2rem; /* Space above the button group */
        }
        .btn {
            flex: 1; /* Make buttons take equal width */
            background-color: #4a2e23; /* Dark brown button */
            border-color: #4a2e23;
            color: #ffffff;
            font-weight: bold;
            padding: 1rem 1rem; /* Larger button padding */
            font-size: 1.1rem;
            border-radius: 0; /* No rounded corners for button */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for buttons */
        }
        .btn:hover {
            background-color: #3b251e; /* Slightly darker brown on hover */
            border-color: #3b251e;
        }
        .btn.btn-outline-dark { /* Styling for Register button if it's outline */
            background-color: #4a2e23; /* Fill color for REGISTER */
            color: #ffffff; /* White text for REGISTER */
            border-color: #4a2e23;
        }
        .btn.btn-outline-dark:hover {
            background-color: #3b251e;
            border-color: #3b251e;
            color: #ffffff;
        }
        .btn-register-icon {
            margin-right: 0.5rem; /* Space between icon and text */
        }

        /* Hide magic link and need account sections if they exist in original */
        .text-center {
            display: none;
        }
    </style>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">LOGIN</h5>

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

                    <div class="mb-4">
                        <label for="floatingEmailInput">Email</label>
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="Email" value="<?= old('email') ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="floatingPasswordInput">Password</label>
                        <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="Password" required>
                    </div>

                    <div class="form-check">
                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <label class="form-check-label d-flex align-items-center">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                                Remember me
                            </label>
                        <?php endif; ?>

                        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                            <a href="<?= url_to('magic-link') ?>" class="forgot-password-link">Forgot Password?</a>
                        <?php elseif (setting('Auth.allowPasswordReset')) : /* Assuming you have a password reset route if magic link is off */ ?>
                            <a href="<?= url_to('forgot') ?>" class="forgot-password-link">Forgot Password?</a>
                        <?php endif ?>
                    </div>

                    <div class="button-group">
                        <?php if (setting('Auth.allowRegistration')) : ?>
                            <a href="<?= url_to('register') ?>" class="btn btn-outline-dark">
                                <i class="fas fa-user-plus btn-register-icon"></i> REGISTER
                            </a>
                        <?php endif ?>
                        <button type="submit" class="btn btn-primary">LOGIN</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>