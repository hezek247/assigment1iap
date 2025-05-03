<?php
session_start();
require 'config.php';

// Prevent session fixation
session_regenerate_id(true);

// Retrieve user input
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate inputs
if (!$username || !$password) {
    die("Please fill in all fields.");
}

// Use prepared statement to prevent SQL Injection
$stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Set secure session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    // Set a secure cookie
    setcookie("auth", session_id(), [
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Strict'
    ]);

    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid username or password.";
}
?>
