<?php 
session_start();
if(isset($_POST["submit"])) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    require('connect.php');
    $stmt = $db->prepare("INSERT INTO userdetails (name, email, contact, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact, $password);

    if($stmt->execute()){
        $_SESSION['toast'] = 'user_created';
        header("Location:signin.php");
    } else {
        echo "Error: ". $stmt->error;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./views/partials/head.php') ?>
    <title>Sign Up</title>
</head>
<body>
    <?php require('./views/partials/nav.php') ?>
        <div class="container mt-4">
            <h1 class="text-center">Sign Up</h1>
            <div class="row d-flex justify-content-center my-4 mx-1">
                <div class="col-12 col-lg-6 p-4 border border-1 rounded-4 w-full">
                    <h4 class="text-primary-emphasis text-center">Create An Account</h4>
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Your First Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="your@emailId.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact No.</label>
                            <input type="text" name="contact" id="contact" class="form-control" placeholder="+91 9876342761" required>
                            <div id="contactHelp"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                                 <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Confirm Password</label>
                            <input type="password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            <div id="passwordHelp"></div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" name="submit" id="submitBtn" value="submit" class="btn btn-outline-primary">Sign Up</button>
                        </div>
                        <p>Already have an Account? <a href="signin.php" class="text-primary-emphasis">Sign In</a></p>
                    </form>
                </div>
            </div>
        </div>

<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    const sumbitBtn = document.querySelector("#submitBtn");

    togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
        
    // toggle icon
    this.innerHTML = type === "password" 
      ? '<i class="bi bi-eye"></i>' 
      : '<i class="bi bi-eye-slash"></i>';
  });

  const confirmPassword = document.querySelector("#confirm_password");
  const message = document.getElementById("passwordHelp");

  confirmPassword.addEventListener("input", function () {
    if (password.value !== confirmPassword.value) {
      message.innerHTML = '<div id="passwordHelp" class="form-text text-danger">Passwords do not match!</div>';
      submitBtn.setAttribute("disabled", true)
      confirmPassword.classList.add("is-invalid");
      confirmPassword.classList.remove("is-valid");
    } else {
      message.innerHTML = '<div id="passwordHelp" class="form-text text-success">Passwords match!</div>';
      submitBtn.removeAttribute("disabled")
      confirmPassword.classList.add("is-valid");
      confirmPassword.classList.remove("is-invalid");
    }
  });

  const contactNumber = document.getElementById('contact');
  const contactMessage = document.getElementById("contactHelp");
  contactNumber.addEventListener('blur', function() {  
    if(contactNumber.value.length != 10) {
        contactMessage.innerHTML = '<div id="contactHelp" class="form-text text-danger">Number must be of 10 Digits</div>';
        submitBtn.setAttribute("disabled", true)
        contactNumber.classList.add("is-invalid");
        contactNumber.classList.remove("is-valid");
    } else {
        contactMessage.innerHTML = '<div id="contactHelp" class="form-text text-success">Valid Number</div>';
        submitBtn.removeAttribute("disabled")
        contactNumber.classList.add("is-valid");
        contactNumber.classList.remove("is-invalid");
    }
  })
</script>        
    <?php require('./views/partials/scripts.php') ?>
</body>
</html>