<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2 class="text-center mb-4">Register</h2>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Inside your register view (e.g., app/Views/register.php) -->
    <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?> <!-- THIS IS ESSENTIAL for CSRF protection -->

        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" id="fullname" value="<?= old('fullname') ?>" required>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= old('username') ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= old('email') ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" id="password_confirm" required>

        <button type="submit">Register</button>
    </form>

    <p class="text-center mt-3">
        Already have an account? <a href="<?= base_url('login') ?>">Login here</a>
    </p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>