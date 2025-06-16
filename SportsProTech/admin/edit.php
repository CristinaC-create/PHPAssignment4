<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate GET
if (!isset($_GET['productCode']) || empty($_GET['productCode'])) {
    echo "Missing product code.";
    exit;
}

$code = $_GET['productCode'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $version = $_POST['version'];
    $releaseDate = $_POST['releaseDate'];

    $sql = 'UPDATE products SET name = ?, version = ?, releaseDate = ? WHERE productCode = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $version, $releaseDate, $code]);

    header('Location: index.php');
    exit;
}

// Fetch product
$stmt = $db->prepare('SELECT * FROM products WHERE productCode = ?');
$stmt->execute([$code]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
</head>
<body>
  <h1>Edit Product</h1>
  <form method="post">
    Code: <strong><?php echo htmlspecialchars($product['productCode']); ?></strong><br>
    Name: <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
    Version: <input type="text" name="version" value="<?php echo htmlspecialchars($product['version']); ?>" required><br>
    Release Date: <input type="date" name="releaseDate" value="<?php echo htmlspecialchars($product['releaseDate']); ?>" required><br>
    <button type="submit">Update</button>
  </form>
  <a href="index.php">Cancel</a>
</body>
</html>