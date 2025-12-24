<?php
session_start();
include "../config/db.php";

$user_id = $_SESSION['user_id'];

$sql = "
SELECT DATE_FORMAT(expense_date, '%M') AS month, 
       SUM(amount) AS total
FROM expenses
WHERE user_id = $user_id
GROUP BY MONTH(expense_date)
";

$result = mysqli_query($conn, $sql);

$months = [];
$totals = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Monthly Expenses</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Monthly Expense Chart</h2>

<canvas id="monthlyChart"></canvas>

<script>
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
            label: 'Expenses',
            data: <?= json_encode($totals) ?>,
        }]
    }
});
</script>

<a href="../dashboard.php">⬅ Back</a>
</body>
</html>
