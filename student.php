<?php
require 'auth.php';
requireRole('student');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Student Dashboard</h2>

    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    <p>Your role is Student.</p>

    <a href="logout.php">Logout</a>
</body>
</html>
