<?php
session_start();

// Accept any email and any password
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($email && $password) {
    $_SESSION['customer'] = $email; // Store the email for the session
    header('Location: customer_dashboard.php');
    exit();
} else {
    $_SESSION['login_error'] = "Email and password required.";
    header('Location: customer_login.php');
    exit();
}