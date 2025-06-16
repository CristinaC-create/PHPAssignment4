<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate input
if (!isset($_GET['techID']) || !is_numeric($_GET['techID'])) {
    echo "Invalid request: techID is required and must be numeric.";
    exit;
}

$techID = (int)$_GET['techID'];

try {
    $stmt = $db->prepare('DELETE FROM technicians WHERE techID = ?');
    $stmt->execute([$techID]);
} catch (PDOException $e) {
    echo "Deletion failed: " . $e->getMessage();
    exit;
}

header('Location: techManager.php');
exit;
?>
