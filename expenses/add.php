<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* FETCH CATEGORIES */
$cat_result = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = $user_id");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_date = $_POST['expense_date'];
    $category_id  = $_POST['category_id'];
    $amount       = $_POST['amount'];
    $note         = $_POST['note'];

    $sql = "
    INSERT INTO expenses (user_id, category_id, amount, expense_date, note)
    VALUES ('$user_id', '$category_id', '$amount', '$expense_date', '$note')
    ";

    mysqli_query($conn, $sql);
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include "../includes/navbar.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">➕ Add Expense</h5>
                </div>

                <div class="card-body">

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="expense_date"
                                   value="<?= date('Y-m-d') ?>"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                <?php while ($cat = mysqli_fetch_assoc($cat_result)) { ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= $cat['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="list.php" class="btn btn-secondary">⬅ Back</a>
                            <button type="submit" class="btn btn-success">Save Expense</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
