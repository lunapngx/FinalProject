<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
<h2>Admin Login</h2>
<form action="<?= url_to('admin.login.action') ?>" method="post">
    <?= csrf_field() ?>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Password</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Log In</button>
</form>
</body>
</html>