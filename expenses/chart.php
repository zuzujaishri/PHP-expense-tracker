<?php
session_start();
include "../config/db.php";

/* 🔐 Login check */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 📊 Fetch category-wise expenses */
$sql = "
    SELECT c.category_name, SUM(e.amount) AS total
    FROM expenses e
    JOIN categories c ON e.category_id = c.id
    WHERE e.user_id = $user_id
    GROUP BY c.category_name
";

$result = mysqli_query($conn, $sql);

$labels = [];
$values = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['category_name'];
    $values[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Category-wise Expense Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2 style="text-align:center;">Category-wise Expense Chart</h2>

<?php if (count($labels) > 0) { ?>
    <canvas id="expenseChart" width="80" height="80"></canvas>

    <script>
        const ctx = document.getElementById('expenseChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    data: <?= json_encode($values) ?>,
                    backgroundColor: [
                        '#ff6384',
                        '#36a2eb',
                        '#ffce56',
                        '#4caf50',
                        '#9c27b0'
                    ]
                }]
            }
        });
    </script>

<?php } else { ?>
    <p style="color:red; text-align:center;">No expense data available.</p>
<?php } ?>

<br>
<a href="../dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>