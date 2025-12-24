<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /PHPPROJECT/expense-tracker/auth/login.php");
    exit();
}
?>

<link rel="stylesheet" href="/PHPPROJECT/expense-tracker/assets/css/dark-mode.css">
<script src="/PHPPROJECT/expense-tracker/assets/js/dark-mode.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/PHPPROJECT/expense-tracker/dashboard.php">
            💸 Expense Tracker
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/PHPPROJECT/expense-tracker/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PHPPROJECT/expense-tracker/expenses/list.php">Expenses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PHPPROJECT/expense-tracker/categories/add.php">Categories</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
    <button onclick="toggleDarkMode()" class="btn btn-outline-light btn-sm">
        🌙
    </button>
</li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown">
                        👤 My Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/PHPPROJECT/expense-tracker/dashboard.php">
                                📊 Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger"
                               href="/PHPPROJECT/expense-tracker/auth/logout.php">
                                🚪 Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
