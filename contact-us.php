<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require('./views/partials/head.php') ?>
  <title>Contact Us</title>
  
</head>
<body>
<?php require('./views/partials/nav.php') ?>
<!-- Hero Section -->
<section class="text-primary-emphasis text-center py-5">
  <div class="container">
    <h1 class="display-4 fw-bold">Get in Touch</h1>
    <p class="lead">We’d love to hear from you! Fill out the form below or reach us directly.</p>
  </div>
</section>

<!-- Contact Section -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">

      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="card shadow-lg border-0 p-4">
          <h3 class="mb-4">Send Us a Message</h3>
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" placeholder="Your name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" placeholder="your@email.com" required>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="subject" placeholder="Subject">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-solid w-100">Send Message</button>
          </form>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-5">
        <div class="card shadow-lg border-0 p-4 h-100">
          <h3 class="mb-4">Reach out to us!</h3>
          <p><i class="bi bi-map me-2 text-primary-emphasis"></i>Surat, Gujarat. India</p>
          <p><i class="bi bi-phone me-2 text-primary-emphasis"></i>+91 9878652153</p>
          <p><i class="bi bi-envelope me-2 text-primary-emphasis"></i>support@trackwise.com</p>

          <hr>
          <h5>Follow Us</h5>
          <div class="d-flex gap-3 mt-2">
            <a href="#" class="text-primary-emphasis fs-4"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-primary-emphasis fs-4"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-primary-emphasis fs-4"><i class="bi bi-linkedin"></i></a>
            <a href="#" class="text-primary-emphasis fs-4"><i class="bi bi-instagram"></i></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">© 2025 Trackwise. All rights reserved.</p>
</footer>

<?php require('./views/partials/scripts.php') ?>
</body>
</html>
