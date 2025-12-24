<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT e.*, c.category_name 
FROM expenses e
LEFT JOIN categories c ON e.category_id = c.id
WHERE e.user_id = $user_id
ORDER BY e.expense_date DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Expenses</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">
    <?php include "../includes/navbar.php"; ?>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">💸 My Expenses</h3>
        <a href="add.php" class="btn btn-primary">+ Add Expense</a>
    </div>

    <!-- Navigation -->
    <div class="mb-3">
        <a href="list.php" class="btn btn-outline-dark btn-sm">All</a>
        <a href="dashboard.php" class="btn btn-outline-success btn-sm">Category Summary</a>
        <a href="monthly.php" class="btn btn-outline-info btn-sm">Monthly Summary</a>
    </div>

    <!-- Expense Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Amount (₹)</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">

                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $row['expense_date'] ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= $row['category_name'] ?? 'Uncategorized' ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                ₹ <?= number_format($row['amount'], 2) ?>
                            </td>
                            <td><?= $row['note'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" 
                                   onclick="return confirm('Delete this expense?')"
                                   class="btn btn-sm btn-danger">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-muted">No expenses found</td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>