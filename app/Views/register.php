<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 2rem 0; }
        .register-container { background-color: #fff; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .register-container h1 { text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 0.75rem; border: none; border-radius: 0.25rem; background-color: #28a745; color: white; font-size: 1rem; cursor: pointer; text-align: center; }
        .btn:hover { background-color: #218838; }
        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 0.5rem; list-style: none; }
        .login-link { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
<div class="register-container">
    <h1>Create an Account</h1>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= old('username') ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirm Password</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <div class="login-link">
        <p>Already have an account? <a href="<?= url_to('login') ?>">Login here</a></p>
    </div>
</div>
</body>
</html>
