<?php 
require('connect.php');


if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
}
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT category, SUM(amount) as total FROM expenses WHERE user_id=? AND type='out' GROUP BY category");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$show_table = false;
if($result->num_rows >= 1) {
    $categoryTotals = $result->fetch_all(MYSQLI_ASSOC);
    $show_table = true;
} else {
    $show_table = false;
}

?>

<html>
  <head>
    <?php if($show_table): ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
        
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Category', 'Amount'],
            <?php foreach ($categoryTotals as $data): ?>
                ['<?= $data['category'] ?>', <?= $data['total'] ?>],
            <?php endforeach; ?>
        ]);

        var options = {
          title: 'Expense Breakdown by Category',
          pieHole: 0.3,
           animation: {
                startup: true, 
                duration: 3500, 
                easing: 'out',   
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        var barChart = new google.visualization.BarChart(document.getElementById('barchart'));

        chart.draw(data, options);
        barChart.draw(data, options);
      }
      window.addEventListener('resize', drawChart);
    </script>
  </head>
  <body>
    <div class="">
        <div id="piechart" style="width: 100%; max-width: 900px; height: 500px;"></div>
    </div>
    <div id="barchart" style="width: 100%; max-width: 900px; height: 500px;"></div>
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
  </body>
</html>