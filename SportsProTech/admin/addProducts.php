<?php
require_once __DIR__ . '/../data/db.php';

// Enable debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['productCode'];
    $name = $_POST['name'];
    $version = $_POST['version'];
    $releaseDate = $_POST['releaseDate'];

    $sql = 'INSERT INTO products (productCode, name, version, releaseDate) VALUES (?, ?, ?, ?)';
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([$code, $name, $version, $releaseDate]);
        header('Location: index.php');
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
  <title>Add Product</title>
</head>
<body>
  <h1>Add Product</h1>
  <form method="post">
      Code: <input type="text" name="productCode" required><br>
      Name: <input type="text" name="name" required><br>
      Version: <input type="text" name="version" required><br>
      Release Date: <input type="date" name="releaseDate" required><br>
      <button type="submit">Add</button>
  </form>
  <a href="index.php">Back to Products</a>
</body>
</html>