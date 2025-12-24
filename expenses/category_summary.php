<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 📊 Category-wise total */
$sql = "
SELECT categories.category_name, 
       SUM(expenses.amount) AS total
FROM expenses
JOIN categories ON expenses.category_id = categories.id
WHERE expenses.user_id = $user_id
GROUP BY categories.category_name
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Category Summary</title>
</head>
<body>

<h2>Category-wise Expense Summary</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Category</th>
        <th>Total Amount</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['category_name'] ?></td>
            <td>₹ <?= $row['total'] ?></td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="../dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
