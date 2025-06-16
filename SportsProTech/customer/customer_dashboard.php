<?php
session_start();
require_once __DIR__ . '/../data/db.php';

if (!isset($_SESSION['customer'])) {
    header("Location: customer_login.php");
    exit();
}

$email = $_SESSION['customer'];

// Fetch customer info
$stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ?");
$stmt->execute([$email]);
$customer = $stmt->fetch();

// Fetch recent orders
$orderStmt = $pdo->prepare("SELECT * FROM orders WHERE customerEmail = ? ORDER BY orderDate DESC LIMIT 5");
$orderStmt->execute([$email]);
$orders = $orderStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Customer Dashboard</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #f7f7f7;
        padding: 40px;
        text-align: center;
    }

    .dashboard-box {
        max-width: 700px;
        margin: 40px auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    td.label {
        font-weight: bold;
        color: #555;
        width: 35%;
    }

    a.button {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 24px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    a.button:hover {
        background-color: #0056b3;
    }

    h2 {
        margin-top: 40px;
        color: #333;
    }
  </style>
</head>
<body>
  <div class="dashboard-box">
    <h1>Welcome, <?php echo htmlspecialchars($customer['firstname'] ?? 'Customer'); ?>!</h1>

    <table>
      <tr>
        <td class="label">Name</td>
        <td><?php echo htmlspecialchars($customer['firstname'] . ' ' . $customer['lastname']); ?></td>
      </tr>
      <tr>
        <td class="label">Email</td>
        <td><?php echo htmlspecialchars($customer['email']); ?></td>
      </tr>
      <tr>
        <td class="label">Phone</td>
        <td><?php echo htmlspecialchars($customer['phone']); ?></td>
      </tr>
      <tr>
        <td class="label">Address</td>
        <td><?php echo htmlspecialchars($customer['address'] . ', ' . $customer['city'] . ', ' . $customer['state'] . ' ' . $customer['postalCode']); ?></td>
      </tr>
      <tr>
        <td class="label">Country</td>
        <td><?php echo htmlspecialchars($customer['countryCode']); ?></td>
      </tr>
    </table>

    <h2>Recent Orders</h2>

    <?php if (count($orders) > 0): ?>
      <table>
        <tr>
          <td class="label">Order ID</td>
          <td class="label">Date</td>
          <td class="label">Status</td>
          <td class="label">Total</td>
        </tr>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo htmlspecialchars($order['orderID']); ?></td>
            <td><?php echo date('Y-m-d', strtotime($order['orderDate'])); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td>$<?php echo number_format($order['total'], 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php else: ?>
      <p style="color: #777;">You have no recent orders.</p>
    <?php endif; ?>

    <a class="button" href="customer_logout.php">Logout</a>
  </div>
</body>
</html>