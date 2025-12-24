<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* TOTAL EXPENSE */
$q1 = mysqli_query($conn, "SELECT SUM(amount) AS total FROM expenses WHERE user_id=$user_id");
$totalExpense = mysqli_fetch_assoc($q1)['total'] ?? 0;

/* TOTAL ENTRIES */
$q2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM expenses WHERE user_id=$user_id");
$totalEntries = mysqli_fetch_assoc($q2)['total'] ?? 0;

/* TOTAL CATEGORIES */
$q3 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories WHERE user_id=$user_id");
$totalCategories = mysqli_fetch_assoc($q3)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card-icon {
            font-size: 30px;
        }
    </style>
</head>
<body>
<?php include "includes/navbar.php"; ?>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📊 Expense Tracker Dashboard</h3>
        <a href="auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Expense</h6>
                        <h4 class="fw-bold text-success">₹ <?= number_format($totalExpense, 2) ?></h4>
                    </div>
                    <div class="card-icon text-success">💰</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Entries</h6>
                        <h4 class="fw-bold"><?= $totalEntries ?></h4>
                    </div>
                    <div class="card-icon">🧾</div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Categories</h6>
                        <h4 class="fw-bold"><?= $totalCategories ?></h4>
                    </div>
                    <div class="card-icon">📂</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Action Buttons -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <a href="expenses/add.php" class="btn btn-primary m-1">➕ Add Expense</a>
            <a href="expenses/list.php" class="btn btn-dark m-1">📋 View Expenses</a>
            <a href="categories/add.php" class="btn btn-secondary m-1">📂 Add Category</a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3">

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Category-wise Chart</h5>
                    <p class="text-muted">View expenses by category</p>
                    <a href="expenses/chart.php" class="btn btn-outline-primary">View Chart</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Monthly Expense Chart</h5>
                    <p class="text-muted">Track spending month-wise</p>
                    <a href="expenses/monthly_chart.php" class="btn btn-outline-success">View Chart</a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>2