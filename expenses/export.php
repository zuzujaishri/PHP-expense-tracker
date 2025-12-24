<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* FETCH EXPENSE DATA */
$sql = "
SELECT 
    e.expense_date,
    c.category_name,
    e.amount,
    e.note
FROM expenses e
JOIN categories c ON e.category_id = c.id
WHERE e.user_id = $user_id
ORDER BY e.expense_date DESC
";

$result = mysqli_query($conn, $sql);

/* FILE HEADERS FOR EXCEL */
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=expenses_" . date('Y-m-d') . ".csv");

/* COLUMN HEADINGS */
echo "Date,Category,Amount,Note\n";

/* DATA ROWS */
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['expense_date'] . ",";
    echo $row['category_name'] . ",";
    echo $row['amount'] . ",";
    echo '"' . str_replace('"', '""', $row['note']) . '"' . "\n";
}

exit();