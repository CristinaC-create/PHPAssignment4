<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate input
if (!isset($_GET['productCode']) || empty($_GET['productCode'])) {
    echo "Invalid request: productCode is required.";
    exit;
}

$code = $_GET['productCode'];

try {
    $stmt = $db->prepare('DELETE FROM products WHERE productCode = ?');
    $stmt->execute([$code]);
} catch (PDOException $e) {
    echo "Deletion failed: " . $e->getMessage();
    exit;
}

header('Location: index.php');
exit;
?>