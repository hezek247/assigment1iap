<?php
require 'config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("Username and password required.");
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert using prepared statement
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

echo "User registered successfully.";
?>
