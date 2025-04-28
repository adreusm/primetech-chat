<?php
$error = $_SESSION['error'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Войти</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php unset($error); ?>
        <?php endif; ?>
        <form action="/login" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Вход</button>
        </form>
    </div>
</body>
</html>