<?php
session_start();
require_once __DIR__ . '/../data/db.php';

if (!isset($_SESSION['technician'])) {
    header("Location: technician_login.php");
    exit();
}

$techEmail = $_SESSION['technician'];

// Get technician ID based on email
$stmt = $pdo->prepare("SELECT * FROM technicians WHERE email = ?");
$stmt->execute([$techEmail]);
$technician = $stmt->fetch();
$techID = $technician['technicianID'] ?? null;

// Get assigned incidents
$incidentStmt = $pdo->prepare("SELECT * FROM incidents WHERE technicianID = ?");
$incidentStmt->execute([$techID]);
$incidents = $incidentStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Technician Dashboard</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        padding: 40px;
        text-align: center;
    }

    .dashboard {
        max-width: 800px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1 {
        color: #333;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
    }

    a.logout {
        display: inline-block;
        margin-top: 20px;
        background: #007BFF;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
    }

    a.logout:hover {
        background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($technician['email']); ?></h1>

    <h2>Your Assigned Incidents</h2>

    <?php if (count($incidents) > 0): ?>
      <table>
        <tr>
          <th>Incident ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Status</th>
          <th>Date Opened</th>
          <th>Customer</th>
        </tr>
        <?php foreach ($incidents as $incident): ?>
        <tr>
          <td><?php echo $incident['incidentID']; ?></td>
          <td><?php echo htmlspecialchars($incident['title']); ?></td>
          <td><?php echo htmlspecialchars($incident['description']); ?></td>
          <td><?php echo htmlspecialchars($incident['status']); ?></td>
          <td><?php echo date('Y-m-d', strtotime($incident['dateOpened'])); ?></td>
          <td><?php echo htmlspecialchars($incident['customerEmail']); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php else: ?>
      <p>No incidents assigned to you yet.</p>
    <?php endif; ?>

    <a class="logout" href="technician_logout.php">Logout</a>
  </div>
</body>
</html>