<?php
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email && $password) {
        $_SESSION['technician'] = $email;
        header('Location: techManager.php');
        exit();
    } else {
        $message = "<p style='color: red;'>Email and password are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Technician Login</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Technician Login</h1>
  <?= $message ?>
  <form method="post">
    <label for="email">Email:</label><br />
    <input type="email" name="email" id="email" required /><br /><br />

    <label for="password">Password:</label><br />
    <input type="password" name="password" id="password" required /><br /><br />

    <button type="submit">Login</button>
  </form>
</body>
</html>