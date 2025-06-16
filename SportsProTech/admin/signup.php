<?php
// Enable error display
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB setup
$dsn = 'mysql:host=localhost;dbname=techsupport';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Registration logic
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if ($user && $pass) {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $hashed);
            $stmt->execute();

            $message = "<p style='color: green;'>User registered successfully!</p>";
        } catch (PDOException $e) {
            $message = "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $message = "<p style='color: orange;'>Username and password are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
</head>
<body>
  <h1>Register New User</h1>
  <?= $message ?>
  <form method="post">
    <label>Username:</label><br />
    <input type="text" name="username" required /><br /><br />

    <label>Password:</label><br />
    <input type="password" name="password" required /><br /><br />

    <button type="submit">Register</button>
  </form>
  <a href="login.php">Back to Login</a>
</body>
</html>