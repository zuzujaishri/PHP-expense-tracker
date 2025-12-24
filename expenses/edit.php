<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$expense_id = $_GET['id'] ?? 0;

/* FETCH EXPENSE */
$expense_sql = "SELECT * FROM expenses WHERE id = $expense_id AND user_id = $user_id";
$expense_result = mysqli_query($conn, $expense_sql);
$expense = mysqli_fetch_assoc($expense_result);

if (!$expense) {
    echo "Expense not found!";
    exit();
}

/* FETCH CATEGORIES */
$cat_result = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = $user_id");

/* UPDATE EXPENSE */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_date = $_POST['expense_date'];
    $category_id  = $_POST['category_id'];
    $amount       = $_POST['amount'];
    $note         = $_POST['note'];

    $sql = "
    UPDATE expenses SET
        expense_date = '$expense_date',
        category_id  = '$category_id',
        amount       = '$amount',
        note         = '$note'
    WHERE id = $expense_id AND user_id = $user_id
    ";

    mysqli_query($conn, $sql);
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark text-center">
                    <h5 class="mb-0">✏️ Edit Expense</h5>
                </div>

                <div class="card-body">

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="expense_date"
                                   value="<?= $expense['expense_date'] ?>"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <?php while ($cat = mysqli_fetch_assoc($cat_result)) { ?>
                                    <option value="<?= $cat['id'] ?>"
                                        <?= ($cat['id'] == $expense['category_id']) ? 'selected' : '' ?>>
                                        <?= $cat['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" name="amount"
                                   value="<?= $expense['amount'] ?>"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea name="note" class="form-control" rows="3"><?= $expense['note'] ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="list.php" class="btn btn-secondary">⬅ Back</a>
                            <button type="submit" class="btn btn-warning">Update Expense</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
