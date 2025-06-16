<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Customer Login</title>
  <link rel="stylesheet" href="../assets/css/customer.css" />
</head>
<body>
  <h1>Customer Login</h1>

  <?php
    session_start();
    if (!empty($_SESSION['login_error'])) {
        echo "<p style='color:red; text-align:center;'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    }
  ?>

  <form method="post" action="customer_auth.php">
    <label for="email">Email:</label><br />
    <input type="email" name="email" id="email" required /><br /><br />

    <label for="password">Password:</label><br />
    <input type="password" name="password" id="password" required /><br /><br />

    <button type="submit">Login</button>
  </form>
</body>
</html>