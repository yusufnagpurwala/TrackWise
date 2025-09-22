<?php 
require('connect.php');


if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM expenses WHERE user_id=?";
$params = [$user_id];
$types = "i";

//Category Filter
if(isset($_GET['category']) && $_GET['category'] !== 'all'){
    $sql .= " AND category=? ";
    $params[] = $_GET['category'];
    $types .= 's';
}

//Type Filter
if(isset($_GET['type']) && $_GET['type'] !== "all") {
    $sql .= " AND type=? ";
    $params[] = $_GET['type'];
    $types .= "s";
}

//Month Filter
if(isset($_GET['month']) && $_GET['month'] !== "all") {
    $month = (int) $_GET['month'];
    $year  = $_GET['year'] ?? date("Y");

    $sql .= " AND MONTH(date) = ? AND YEAR(date) = ?";
    $params[] = $month;
    $params[] = $year;
    $types .= "ii";
}

//Sort by Amount
$orderBy = " ORDER BY date DESC";
if (isset($_GET['amount']) && in_array($_GET['amount'], ['asc', 'desc'])){
    $orderBy = " ORDER BY amount " . strtoupper($_GET['amount']);
}
$sql .= $orderBy;

$stmt = $db->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$show_table = false;

if($result->num_rows >= 1) {
    $expense_data = $result->fetch_all(MYSQLI_ASSOC);
    $show_table = true;
} else {
    $show_table = false;
}

function deleteEntry($id) {
    require('connect.php');
    global $user_id;
    $stmt = $db->prepare('DELETE FROM expenses WHERE expense_id=? AND user_id=?');
    $stmt->bind_param('ii', $id, $user_id);
    return $stmt->execute();
}

if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
    if (deleteEntry($_POST['delete_id'])) {
        echo "<script>window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        $_SESSION['toast'] = "record_delete";
        exit();
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }
}

//Months from expense table
$sqlMonths = "SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM expenses WHERE user_id=? ORDER BY year DESC, month DESC";
$stmtMonths = $db->prepare($sqlMonths);
$stmtMonths->bind_param("i", $user_id);
$stmtMonths->execute();
$resultMonths = $stmtMonths->get_result();
$months = $resultMonths->fetch_all(MYSQLI_ASSOC);




$categories = ["Travel", "Food", "Entertainment", "Bills", "Shopping", "Maintenance", "Health", "Education", "Salary","Income", "Other"];

?>


<?php if($show_table): ?>
<div class="container max-auto-lg">
    <div class="d-flex justify-content-between">
        <h4>All Expenses</h4>
        <a href="add-expense.php">
            <button class="btn btn-solid">Add Expense</button>
        </a>
    </div>
    <form method="get">
        <div class="row my-2">
            <div class="mb-3 col-12 col-lg">
                <label class="form-label">
                <i class="bi bi-tag text-primary-emphasis"></i>
                <span class="fw-semibold"> Filter By Categories</span></label>
                <select name="category" class="selectpicker form-select" id="inputGroupSelect01">
                    <option value="all">
                        All Categories 
                    </option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>" >
                            <?= $category ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 col">
                <label class="form-label">
                <i class="bi bi-arrow-down-up text-primary-emphasis"></i>
                <span class="fw-semibold"> Filter By Type</span></label>
                <select name="type" class="selectpicker form-select" id="inputGroupSelect01">
                    <option value="all" selected>All types</option>
                    <option value="in">Cash In</option>
                    <option value="out">Cash Out</option>
                </select>
            </div>
            <div class="mb-3 col">
                <label class="form-label">
                <i class="bi bi-currency-rupee text-primary-emphasis"></i>
                <span class="fw-semibold"> Sort By Amount</span></label>
                <select name="amount" class="selectpicker form-select" id="inputGroupSelect01">
                    <option value="all" selected>Sort By Amount</option>
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col col-lg-6">
                <label class="form-label">
                <i class="bi bi-calendar text-primary-emphasis"></i>
                <span class="fw-semibold">Filter By Month</span></label>
                <select name="month" class="selectpicker form-select" id="inputGroupSelect01">
                    <option value="all" selected>Select Month</option>
                    <?php foreach ($months as $month):
                        $monthNum = $month['month'];
                        $year = $month['year'];
                        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10))
                    ?>
                    <option value="<?= $monthNum ?>" 
                        <?= (isset($_GET['month']) && $_GET['month'] == $monthNum ? 'selected' : '') ?>>
                        <?= $monthName . " " . $year ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="">
                <button type="submit" class="btn btn-solid"><i class="bi bi-filter-circle"></i> Apply Filter</button>
            </div>
        </div>
    </form>
    <div class="table-responsive border border-1 rounded-4 my-4 p-2">
    <table class="table overflow-x-auto">
        <thead>
            <th class="fw-semibold">Date</th>
            <th class="fw-semibold">Description</th>
            <th class="fw-semibold">Category</th>
            <th class="fw-semibold">Type</th>
            <th class="fw-semibold">Amount</th>
            <th class="fw-semibold">Actions</th>
        </thead>
        <tbody>
            <?php foreach ($expense_data as $row): ?>
            <tr>
                <td><?= $row['date']; ?></td>
                <td>
                    <p class="fst-italic"><?= $row['description']; ?></p>
                </td>
                <td>
                    <div class="my-1">
                        <span class="py-1 px-2 rounded-pill bg-info-subtle text-info-emphasis fw-semibold">
                            <?= $row['category']; ?>
                        </span>
                    </div>
                </td>
                <td>
                     <div class="my-1">
                        <?php if ($row['type'] === 'out'): ?>
                            <span class="py-1 px-2 bg-danger-subtle rounded-pill text-danger-emphasis fw-semibold">out</span>
                        <?php else: ?>
                            <span class="py-1 px-2 bg-success-subtle rounded-pill text-success-emphasis fw-semibold">in</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="fw-semibold">
                    <?= ($row['type'] === 'out' ? '-' : '+') . abs($row['amount']) . '/-'; ?>
                </td>
                <td>
                    <div  class="d-flex gap-2">
                        <div>
                            <a href="edit-expense.php?id=<?= $row['expense_id'] ?>&user_id=<?= $_SESSION['user_id'] ?>">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-id="<?= $row['expense_id'] ?>" data-bs-target="#DeleteModal">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php else: ?>
    <div class="container my-5">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
            <div class="text-center">
            <div class="mb-3">
                <i class="bi bi-search text-secondary"></i>
            </div>
            <h5 class="fw-semibold text-muted">No records found</h5>
            <p class="text-secondary">Try adjusting your filters or <a href="add-expense.php" class="text-decoration-none">add a new expense</a>.</p>
            <a href="index.php" class="btn btn-outline-primary mt-3">
                <i class="bi bi-arrow-repeat"></i> Reset Filters
            </a>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-primary-emphasis" id="exampleModalLabel">Delete this entry?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-light-emphasis">
        This action cannot be undone. This will permanently delete the selected expense.
      </div>
      <div class="m-3 d-flex justify-content-between">
          <form method="post">
            <input type="hidden" name="delete_id" id="delete_id">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </form>
        </div>
    </div>
  </div>
</div>

<script>
    var deleteModal = document.getElementById('DeleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var expenseId = button.getAttribute('data-id');
        document.getElementById('delete_id').value = expenseId;
    });
</script>