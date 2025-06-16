<?php
session_start();
if (!isset($_SESSION['technician'])) {
    header('Location: technician_login.php');
    exit();
}

require_once __DIR__ . '/../data/db.php'; // ✅ use the $pdo connection

// (Optional) Fetch all technicians
$result = $pdo->query("SELECT * FROM technicians");

// ✅ Fetch all work orders
$stmt = $pdo->query("SELECT * FROM work_orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Technician Dashboard</title>
</head>
<body>
  <h1>Welcome, <?= htmlspecialchars($_SESSION['technician']) ?></h1>

  <h2>All Work Orders</h2>
  <?php if (count($orders) === 0): ?>
    <p>No work orders available.</p>
  <?php else: ?>
    <table border="1" cellpadding="8">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Assigned To</th>
      </tr>
      <?php foreach ($orders as $order): ?>
      <tr>
        <td><?= htmlspecialchars($order['id']) ?></td>
        <td><?= htmlspecialchars($order['title']) ?></td>
        <td><?= htmlspecialchars($order['description']) ?></td>
        <td><?= htmlspecialchars($order['status']) ?></td>
        <td><?= htmlspecialchars($order['assignedTo']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <br />
  <a href="technician_logout.php">Logout</a>
</body>
</html>