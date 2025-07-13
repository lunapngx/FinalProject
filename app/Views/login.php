<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2 class="text-center mb-4">Login</h2>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger text-center">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('attemptLogin') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="identifier">Email or Username</label>
            <input type="text" name="identifier" id="identifier" class="form-control" value="<?= old('identifier') ?>" required autofocus>
            <?php if (isset($validation) && $validation->hasError('identifier')) : ?>
                <div class="text-danger mt-1"><?= $validation->getError('identifier') ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <?php if (isset($validation) && $validation->hasError('password')) : ?>
                <div class="text-danger mt-1"><?= $validation->getError('password') ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

    <p class="text-center mt-3">
        Don't have an account? <a href="<?= base_url('register') ?>">Register here</a>
    </p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>