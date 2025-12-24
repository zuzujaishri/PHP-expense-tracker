<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 📊 Monthly total */
$sql = "
SELECT 
    MONTH(expense_date) AS month,
    YEAR(expense_date) AS year,
    SUM(amount) AS total
FROM expenses
WHERE user_id = $user_id
GROUP BY YEAR(expense_date), MONTH(expense_date)
ORDER BY year DESC, month DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Summary</title>
</head>
<body>

<h2>Monthly Expense Summary</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Month</th>
        <th>Total Amount</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>
                <?= date("F Y", mktime(0, 0, 0, $row['month'], 1, $row['year'])) ?>
            </td>
            <td>₹ <?= $row['total'] ?></td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="../dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
