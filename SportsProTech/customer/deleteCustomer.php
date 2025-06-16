<?php
require_once __DIR__ . '/../data/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerID = $_POST['customerID'];

    $stmt = $pdo->prepare("DELETE FROM customers WHERE customerID = ?");
    $success = $stmt->execute([$customerID]);

    if ($success && $stmt->rowCount() > 0) {
        $message = "Customer with ID $customerID was deleted successfully.";
    } else {
        $message = "Customer not found or already deleted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Customer</title>
</head>
<body>
    <h1>Delete Customer</h1>

    <?php if (!empty($message)) : ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="customerID">Enter Customer ID to Delete:</label><br>
        <input type="number" name="customerID" required><br><br>

        <button type="submit">Delete</button>
    </form>

    <br><a href="index.php">Back to Customer Dashboard</a>
</body>
</html>