<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #fff; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-container h1 { text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 0.75rem; border: none; border-radius: 0.25rem; background-color: #007bff; color: white; font-size: 1rem; cursor: pointer; text-align: center; }
        .btn:hover { background-color: #0056b3; }
        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .register-link { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Login</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg_success') ?></div>
    <?php endif; ?>

    <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <div class="register-link">
        <p>Need an account? <a href="<?= url_to('register') ?>">Register here</a></p>
    </div>
</div>
</body>
</html>
