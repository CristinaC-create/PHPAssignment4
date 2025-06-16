<?php
require_once __DIR__ . '/../data/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        // 🔓 Dev mode: bypass actual user check
        $_SESSION['admin'] = $username;
        header('Location: project_manager.php');
        exit();
    } else {
        echo "<p style='color: orange;'>Both fields are required.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h1>Admin Login</h1>
  <form method="post" action="login.php">
    <label for="username">Username:</label><br />
    <input type="text" id="username" name="username" placeholder="Enter your username" required /><br /><br />

    <label for="password">Password:</label><br />
    <input type="password" id="password" name="password" placeholder="Enter your password" required /><br /><br />

    <button type="submit">Login</button>
  </form>
</body>
</html>