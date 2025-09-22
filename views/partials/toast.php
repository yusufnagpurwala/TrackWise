<div class="toast-container position-fixed top-0 end-0 p-3">
    <!-- Login Toast -->
    <div id="loginToast" 
    class="toast align-items-center text-bg-success border-0" 
    role="alert" 
    aria-live="assertive" 
    aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
         <i class="bi bi-check2"></i> 
         Welcome, <?php echo $_SESSION['name'] ?? ''; ?>.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" 
      data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <!-- Account Creation Toast -->
    <div id="AccountToast" 
    class="toast align-items-center text-bg-success border-0" 
    role="alert" 
    aria-live="assertive" 
    aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-check2"></i>
          Account Created.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" 
      data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <!-- Profile Update -->
    <div id="ProfileUpdateToast" 
    class="toast align-items-center text-bg-primary border-0" 
    role="alert" 
    aria-live="assertive" 
    aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-check2"></i>
          Profile Updated
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" 
      data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  
  <div id="errorToast" 
  class="toast align-items-center text-bg-danger border-0" 
  role="alert" 
  aria-live="assertive" 
       aria-atomic="true">
       <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-x-circle-fill"></i>
        Invalid email or password! 
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" 
      data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
  <!-- Login Toast -->

  <!-- Record Toast -->
  <div id="recordToast" 
  class="toast align-items-center text-bg-success border-0" 
  role="alert" 
  aria-live="assertive" 
  aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      <span>
        <i class="bi bi-check2"></i>
        </span> Record Added.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" 
              data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
          
          <div id="record_errorToast" 
          class="toast align-items-center text-bg-danger border-0" 
          role="alert" 
          aria-live="assertive" 
          aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              <i class="bi bi-x-circle-fill"></i>
              Error..Record not Added.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" 
            data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        
          <div id="record_DeleteToast" 
          class="toast align-items-center text-bg-info border-0" 
          role="alert" 
          aria-live="assertive" 
          aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-white">
              <i class="bi bi-trash3"></i>
              Record Deleted.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" 
            data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        <!-- Record Toast -->
        
      </div>
      
<script>
  document.addEventListener("DOMContentLoaded", function () {
    <?php if (isset($_SESSION['toast']) && $_SESSION['toast'] === "loginToast") : ?>
    var toastEl = document.getElementById('loginToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 5000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "user_created") : ?>
    var toastEl = document.getElementById('AccountToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "user_updated") : ?>
    var toastEl = document.getElementById('ProfileUpdateToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "ErrorToast") : ?>
    var toastEl = document.getElementById('errorToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "record_success") : ?>
    var toastEl = document.getElementById('recordToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "record_error") : ?>
    var toastEl = document.getElementById('record_errorToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php elseif (isset($_SESSION['toast']) && $_SESSION['toast'] === "record_delete") : ?>
    var toastEl = document.getElementById('record_DeleteToast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
    <?php endif; unset($_SESSION['toast']); ?>
  });
</script>