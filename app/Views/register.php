<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

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
    .btn-primary {
        background-color: #4a2e23; /* Dark brown button */
        border-color: #4a2e23;
        color: #ffffff;
        font-weight: bold;
        padding: 1rem 2rem; /* Larger button padding */
        font-size: 1.1rem;
        border-radius: 0; /* No rounded corners for button */
        width: 100%; /* Full width button */
        margin-top: 2rem; /* Space above button */
    }
    .btn-primary:hover {
        background-color: #3b251e; /* Slightly darker brown on hover */
        border-color: #3b251e;
    }
    .form-check {
        margin-top: 1.5rem;
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Align items vertically */
    }
    .form-check-input {
        margin-right: 0.5rem; /* Space between checkbox and text */
        width: 1.25em; /* Make checkbox slightly larger */
        height: 1.25em;
        border: 1px solid #4a2e23; /* Dark brown border for checkbox */
    }
    .form-check-label {
        color: #4a2e23; /* Dark brown for checkbox label */
        font-size: 0.9rem;
    }
    .form-check-label a {
        color: #4a2e23; /* Dark brown for links in checkbox label */
        text-decoration: underline;
    }
    /* Remove the "Have an account?" text below the button */
    .text-center {
        display: none;
    }
</style>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">SIGN UP</h5>

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

            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label for="floatingFirstNameInput">First Name</label>
                    <input type="text" class="form-control" id="floatingFirstNameInput" name="first_name" inputmode="text" autocomplete="given-name" placeholder="First Name" value="<?= old('first_name') ?>" required>
                </div>

                <div class="mb-4">
                    <label for="floatingLastNameInput">Last Name</label>
                    <input type="text" class="form-control" id="floatingLastNameInput" name="last_name" inputmode="text" autocomplete="family-name" placeholder="Last Name" value="<?= old('last_name') ?>" required>
                </div>

                <div class="mb-4">
                    <label for="floatingEmailInput">Email</label>
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="Email" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-4">
                    <label for="floatingPasswordInput">Password</label>
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="Password" required>
                </div>

                <div class="mb-4">
                    <label for="floatingPasswordConfirmInput">Confirm Password</label>
                    <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="Confirm Password" required>
                </div>