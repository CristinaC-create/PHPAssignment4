<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn = 'mysql:host=localhost;dbname=techsupport'; // ✅ Confirm your DB name here
$username = 'root';
$password = '';  // or 'root123' if you've set a password

try {
    $pdo = new PDO($dsn, $username, $password); // ✅ CHANGED FROM $db TO $pdo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>