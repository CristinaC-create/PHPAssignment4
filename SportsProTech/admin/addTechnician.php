<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName  = $_POST['lastName'];
    $email     = $_POST['email'];
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hash
    $phone     = $_POST['phone'];

    $sql = 'INSERT INTO technicians (firstName, lastName, email, password, phone) VALUES (?, ?, ?, ?, ?)';

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $password, $phone]);
        header('Location: techManager.php');
        exit();
    } catch (PDOException $e) {
        echo "Insert failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Technician</title>
</head>
<body>
  <h1>Add Technician</h1>
  <form method="post">
      First Name: <input type="text" name="firstName" required><br>
      Last Name: <input type="text" name="lastName" required><br>
      Email: <input type="email" name="email" required><br>
      Password: <input type="password" name="password" required><br>
      Phone: <input type="text" name="phone" required><br>
      <button type="submit">Add</button>
  </form>
  <a href="techManager.php">Back to Technicians</a>
</body>
</html>