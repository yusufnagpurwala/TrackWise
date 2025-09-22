<?php 
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./views/partials/head.php') ?>
    <title>TrackWise - Analytics</title>
</head>
<body>
<?php require('./views/partials/nav.php') ?>


<?php require('./views/charts.php') ?>
<?php require('./views/expensetable.php') ?>
<?php require('./views/partials/scripts.php') ?>
</body>
</html>