<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $phone     = trim($_POST['phone']);

    if ($firstName && $lastName && $email && $password && $phone) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = 'INSERT INTO customers (firstName, lastName, email, password, phone) VALUES (?, ?, ?, ?, ?)';
            $stmt = $db->prepare($sql);
            $stmt->execute([$firstName, $lastName, $email, $hashed, $phone]);

            $message = "<p style='color:green;'>Registration successful!</p>";
        } catch (PDOException $e) {
            $message = "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $message = "<p style='color:orange;'>All fields are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Registration</title>
</head>
<body>
  <h1>Register as a Customer</h1>
  <?= $message ?>
  <form method="post">
    First Name: <input type="text" name="firstName" required><br><br>
    Last Name: <input type="text" name="lastName" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Phone: <input type="text" name="phone" required><br><br>

    <button type="submit">Register</button>
  </form>
  <a href="login.php">Already have an account? Login</a>
</body>
</html>