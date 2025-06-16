<?php
require_once __DIR__ . '/../data/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate techID
if (!isset($_GET['techID']) || !is_numeric($_GET['techID'])) {
    echo "Invalid technician ID.";
    exit;
}

$techID = (int)$_GET['techID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName  = $_POST['lastName'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $phone     = $_POST['phone'];

    $sql = 'UPDATE technicians SET firstName = ?, lastName = ?, email = ?, password = ?, phone = ? WHERE techID = ?';

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([$firstName, $lastName, $email, $password, $phone, $techID]);
        header('Location: techManager.php');
        exit();
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
        exit();
    }
}

// Fetch technician
$stmt = $db->prepare('SELECT * FROM technicians WHERE techID = ?');
$stmt->execute([$techID]);
$technician = $stmt->fetch();

if (!$technician) {
    echo "Technician not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Technician</title>
</head>
<body>
  <h1>Edit Technician</h1>
  <form method="post">
    First Name: <input type="text" name="firstName" value="<?= htmlspecialchars($technician['firstName']) ?>" required><br>
    Last Name: <input type="text" name="lastName" value="<?= htmlspecialchars($technician['lastName']) ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($technician['email']) ?>" required><br>
    Password: <input type="text" name="password" value="<?= htmlspecialchars($technician['password']) ?>" required><br>
    Phone: <input type="text" name="phone" value="<?= htmlspecialchars($technician['phone']) ?>" required><br>
    <button type="submit">Update</button>
  </form>
  <a href="techManager.php">Back to Technicians</a>
</body>
</html>