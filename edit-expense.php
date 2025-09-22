<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
require('connect.php');

$stmt = $db->prepare('SELECT * FROM expenses WHERE expense_id=? and user_id=?');
$stmt->bind_param('ii', $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1) {
    $data = $result->fetch_assoc();
} else {
    echo "Error: ". $stmt->error;
}

if(isset($_POST['submit'])){
    $date = $_POST['date'];
    $desc = $_POST['desc'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amt'];
    $notes = $_POST['notes'];

    $stmt = $db->prepare("UPDATE expenses SET description=?, type=?, category=?, amount=?, date=?, notes=? WHERE expense_id=? AND user_id=? ");
    $stmt->bind_param('sssdssii', $desc, $type, $category, $amount, $date, $notes, $id, $user_id);
    if($stmt->execute()){
        $_SESSION['toast'] = "record_success";
        header("Location: index.php");
        exit();
    } else {
        echo $stmt->error;
    }
    
}

$categories = ["Travel", "Food", "Entertainment", "Bills", "Shopping", "Health", "Maintenance", "Education", "Salary", "Income", "Other"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./views/partials/head.php') ?>
    <title>Document</title>
</head>
<body>
<?php require('./views/partials/nav.php') ?>
<div class="container mt-4">
    <h2 class="text-center text-primary-emphasis">Edit Expense</h2>
    <nav class="d-flex justify-content-center" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-primary-emphasis">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Expense</li>
        </ol>
    </nav>
    <div class="row d-flex justify-content-center my-4 mx-1">
        <div class="col-12 col-lg-6 p-4 border shadow rounded-4 w-full">
            <h6 class="text-center text-secondary-emphasis">Fill in the information below to track your finances</h6>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">
                    <i class="bi bi-calendar text-primary-emphasis"></i>
                    <span class="fw-semibold"> Date </span></label>
                    <input type="date" name="date" value="<?php echo $data['date'] ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                    <i class="bi bi-file-earmark-text text-primary-emphasis"></i>
                    <span class="fw-semibold"> Description </span></label>
                    <input type="text" name="desc" value="<?php echo $data['description'] ?>" placeholder="eg. Coffee with friends..." class="form-control" required>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">
                        <i class="bi bi-file-earmark-text text-primary-emphasis"></i>
                        <span class="fw-semibold"> Type </span></label>
                        <select name="type" class="selectpicker form-select" id="inputGroupSelect01">
                            <option value="in" <?= ($data['type'] === 'in') ? 'selected' : '' ?>>Cash In</option>
                            <option value="out" <?= ($data['type'] === 'out') ? 'selected' : '' ?>>Cash Out</option>
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">
                        <i class="bi bi-tag text-primary-emphasis"></i>
                        <span class="fw-semibold"> Category </span></label>
                        <select name="category" class="selectpicker form-select" id="inputGroupSelect01">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category ?>" 
                                    <?= ($data['category'] === $category) ? 'selected' : '' ?>>
                                    <?= $category ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                    <i class="bi bi-currency-rupee text-primary-emphasis"></i>
                    <span class="fw-semibold"> Amount </span></label>
                    <input type="number" value="<?php echo $data['amount'] ?>" name="amt" placeholder="Enter Amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                    <i class="bi bi-file-earmark text-primary-emphasis"></i>
                    <span class="fw-semibold"> Notes(Optional) </span></label>
                    <textarea type="text" name="notes" value="<?php echo $data['notes'] ?>" placeholder="Add any additional information..." class="form-control" style="height: 100px"></textarea>
                </div>
                <div class="d-flex d-grid gap-2 mb-3">
                    <button type="submit" name="submit" class="btn btn-solid col-8">Update Entry</button>
                    <a href="index.php" class="btn btn-outline-primary col-4"><i class="bi bi-arrow-left me-1"></i>Go back</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require('./views/partials/scripts.php') ?> 
</body>
</html>