<?php
require 'auth.php';
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header(
        'Location: ' .
        ($_SESSION['role'] === 'admin' ? 'admin.php' : 'student.php')
    );
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare(
        'SELECT id, username, password, role
         FROM users WHERE username = ?'
    );
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_activity'] = time();

        $update = $pdo->prepare(
            'UPDATE users SET last_login = NOW() WHERE id = ?'
        );
        $update->execute([$user['id']]);

        header(
            'Location: ' .
            ($user['role'] === 'admin' ? 'admin.php' : 'student.php')
        );
        exit;
    }

    $error = 'Invalid username or password.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($_GET['timeout'])): ?>
        <p>Your session expired. Please log in again.</p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>