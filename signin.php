<?php 
session_start();
if(isset($_POST['submit'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];

    require("connect.php");

    $stmt = $db->prepare("SELECT * FROM userdetails WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['contact'] = $user['contact'];
            $_SESSION['toast'] = "loginToast"; 
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['toast'] = "ErrorToast";
        } 
    } 
    else {
            $_SESSION['toast'] = "ErrorToast";
        }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./views/partials/head.php') ?>
    <title>Sign In</title>
</head>
<body>
    <?php require('./views/partials/nav.php') ?>
        <div class="container mt-4">
            <h1 class="text-center">Sign In</h1>
            <div class="row d-flex justify-content-center my-4 mx-1">
                <div class="col-12 col-lg-6 p-4 border border-1 rounded-4 w-full">
                    <h4 class="text-primary-emphasis text-center">Login</h4>
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="your@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                                 <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" name="submit" value="submit" class="btn btn-outline-primary" id="liveToastBtn">Login</button>
                        </div>
                        <p>New User? <a href="signup.php" class="text-primary-emphasis">Create An Account</a></p>
                    </form>
                </div>
            </div>
        </div>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // toggle icon
    this.innerHTML = type === "password" 
      ? '<i class="bi bi-eye"></i>' 
      : '<i class="bi bi-eye-slash"></i>';
  });
</script>
    <?php require('./views/partials/toast.php'); ?>
    <?php require('./views/partials/scripts.php') ?>
</body>
</html>

