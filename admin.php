<?php
require 'auth.php';
requireRole('admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    <p>Your role is Administrator.</p>

    <a href="logout.php">Logout</a>
</body>
</html>