<?php 
session_start();

if(!isset($_SESSION['name'])){
    header('Location:signin.php');
}

require('connect.php');
$user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT * FROM expenses WHERE user_id=?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $totals = [
    'cashIn' => 0,
    'cashOut' => 0
    ];
    $remainder = 0;

    $showTable = false; 

    if($result->num_rows >= 1) {
        $expense_data = $result->fetch_all(MYSQLI_ASSOC);
        function calc($expense_data){
            $cashIn = 0;
            $cashOut = 0;
            foreach ($expense_data as $data) {
                if($data['type'] === 'in'){
                    $cashIn += $data['amount'];
                } else {
                    $cashOut += $data['amount'];
                }
            }

            return [
                'cashIn' => $cashIn,
                'cashOut' => $cashOut
            ];
        } 
        $totals = calc($expense_data);
        $remainder = $totals['cashIn'] - $totals['cashOut'];

        $showTable = true;
    } elseif ($result->num_rows === 0) {
        $showTable = false;
    }
     else {
        $showTable = false;
        echo "Error: ". $stmt->error;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./views/partials/head.php') ?>
    <title>TrackWise</title>
</head>
<body>
    <?php require('./views/partials/nav.php') ?>
    <?php if($showTable) : ?>
    <div class="container row gap-4 my-5 mx-auto">
        <div class="col-md col-sm-12 border border-1 rounded-4 py-3 px-4">
            <div class="d-flex justify-content-between text-success">
                <p class="fw-semibold">Cash in</p>
                <div>
                    <i class="bi bi-arrow-down-left"></i>
                </div>
            </div>
            <h2><?php echo $totals['cashIn'] ?></h2>
            <p class="fst-italic">Total Income</p>
        </div>
        <div class="col-md col-sm-12 border border-1 rounded-4 py-3 px-4">
            <div class="d-flex justify-content-between text-danger">
                <p class="fw-semibold">Cash out</p>
                <div>
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>
            <h2><?php echo $totals['cashOut'] ?></h2>
            <p class="fst-italic">Total Expenses</p>
        </div>
        <div class="col-md col-sm-12 border border-1 rounded-4 py-3 px-4">
            <div class="d-flex justify-content-between text-primary-emphasis">
                <p class="fw-semibold">Remainder</p>
                <div>
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            <h2><?php echo $remainder ?></h2>
            <p class="fst-italic">Balance</p>
        </div>
    </div>

<?php require('./views/expensetable.php') ?>
<?php else: ?>
    <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 text-center">
      <!-- Illustration (optional) -->
      <div class="mb-4">
        <i class="bi bi-wallet2 text-primary" style="font-size: 4rem;"></i>
      </div>

      <!-- Heading -->
      <h2 class="fw-bold text-primary-emphasis">No Expenses Yet</h2>

      <!-- Message -->
      <p class="text-muted mb-4">
        Looks like you haven’t added any expenses yet. Start tracking your money today by adding your first entry.
      </p>

      <!-- CTA Button -->
      <a href="add-expense.php" class="btn btn-outline-primary btn-lg px-4">
        <i class="bi bi-plus-circle"></i> Add Your First Expense
      </a>
    </div>
  </div>
</div>

<?php endif; ?>
<?php require('./views/partials/toast.php') ?>
<?php require('./views/partials/scripts.php') ?>
</body>
</html>