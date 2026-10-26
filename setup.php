<?php
require 'db.php';

$users = [
    ['admin', 'Admin@123', 'admin'],
    ['student', 'Student@123', 'student']
];

$stmt = $pdo->prepare(
    "INSERT INTO users (username, password, role)
     VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE
     password = VALUES(password),
     role = VALUES(role)"
);

foreach ($users as [$username, $password, $role]) {
    $stmt->execute([
        $username,
        password_hash($password, PASSWORD_DEFAULT),
        $role
    ]);
}

echo "Test users created successfully.";