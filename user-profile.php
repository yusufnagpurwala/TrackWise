<?php 
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location:signin.php");
}

if(isset($_GET['id'])){
  $id = $_GET['id'];
}

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];

  require('connect.php');
  $stmt = $db->prepare("UPDATE userdetails SET name=?, email=?, contact=? WHERE user_id = ?");
  $stmt->bind_param('sssi', $name, $email, $contact, $_SESSION['user_id']);

  if( $stmt->execute()){
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['contact'] = $contact;
    $_SESSION['toast'] = 'user_updated';
    header("Location: user-profile.php");
    exit();
  } else {
     $_SESSION['toast'] = "ErrorToast";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('./views/partials/head.php') ?>
  <title>User Profile</title>
</head>

<?php require('./views/partials/nav.php') ?>
<!-- Profile Section -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">

        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body text-center p-5">

            <!-- Profile Picture -->
            <div class="mb-1">
              <!-- <img src="https://via.placeholder.com/120" alt="Profile Picture" class="rounded-circle img-fluid shadow"> -->
               <i class="bi bi-person fs-1 text-primary-emphasis"></i>
            </div>

            <!-- User Info -->
            <form method="post">
            
            <?php if(isset($id)): ?>
            <input type="text" name='name' value="<?= $_SESSION['name'] ?>" class="fw-bold mb-1 fs-3 text-center" autofocus>
            <?php else: ?>
            <h3 class="fw-bold mb-1"><?php echo $_SESSION['name'] ?></h3>
            <p class="text-muted">Software Developer</p>
            <?php endif; ?>

            <hr class="my-4">

            <!-- Details -->
            <div class="text-start px-3">
              <?php if(isset($id)): ?>
                <p>
                  <span><i class="bi bi-envelope text-primary me-1"></i> </span>
                  <input type="email" name='email' value="<?= $_SESSION['email'] ?>" class="">
                </p>
                <p>
                  <span><i class="bi bi-telephone text-success me-1"></i></span> 
                  <input type="text" name='contact' value="<?= $_SESSION['contact'] ?>" class="">
                </p>
                <?php else: ?>
                <p>
                  <span><i class="bi bi-envelope text-primary me-1"></i> </span>
                  <?php echo $_SESSION['email'] ?>
                </p>
                <p>
                  <span><i class="bi bi-telephone text-success me-1"></i></span> 
                  +91 <?php echo $_SESSION['contact'] ?>
                </p>
                <?php endif; ?>
            </div>

            <hr class="my-4">

            <!-- Actions -->
            <div class="d-flex justify-content-center gap-3">
              <?php if(isset($id)): ?>
              <button type="submit" name="submit" class="btn btn-outline-primary">Update Profile</button>
              <a href="user-profile.php" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt me-1"></i>Cancel</a>
              <?php else: ?>
              <a href="user-profile.php?id=<?= $_SESSION['user_id'] ?>" class="btn btn-outline-primary"><i class="bi bi-pencil-square me-1"></i> Edit Profile</a>
              <a href="logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
              <?php endif; ?>
            </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php require('./views/partials/toast.php') ?>
<?php require('./views/partials/scripts.php') ?>
</body>
</html>
