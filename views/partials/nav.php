<?php 
function setActive($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'fw-bold text-primary-emphasis' : '';
}
?>

<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background-color: #ffffff;" data-bs-theme="light">
  <div class="container-fluid">
    <a class="navbar-brand d-flex justify-content-center gap-2" href="index.php">
        <img src="./public/icons/logo.svg" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
        <span class="fw-semibold">TrackWise</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= setActive('index.php') ?>" aria-current="page" href="index.php">Dashboard</a>
        </li>
        <?php if(isset(($_SESSION['name']))): ?>
        <li class="nav-item">
          <a class="nav-link <?= setActive('analytics.php') ?>" href="analytics.php">Analytics</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['name']; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link <?= setActive('contact-us.php') ?>" href="contact-us.php">Contact Us</a>
        </li>
      </ul>
      <div class="d-flex gap-2">
        <?php if(isset(($_SESSION['name']))): ?>
        <a href="add-expense.php">
          <button class="btn btn-outline-primary">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-plus-lg"></i>
              <span>Add Expense</span>
            </div>
          </button>
        </a>
        <a href="user-profile.php">
          <button class="btn btn-outline-primary">
            <div class="d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
              </svg>
              <span>Profile</span>
            </div>
          </button>
        </a>
      <?php else : ?>
        <a href="signin.php">
          <button class="btn btn-outline-primary">Sign In</button>
        </a>
        <a href="signup.php">
          <button class="btn btn-solid">Sign Up</button>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>