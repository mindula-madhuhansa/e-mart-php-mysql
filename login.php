<?php

session_start();

include("server/connection.php");

if (isset($_SESSION['logged_in'])) {
  header("location: account.php");
  exit();
}

if (isset($_POST['login_btn'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? AND user_password = ? LIMIT  1");

  $stmt->bind_param("ss", $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['logged_in'] = true;

      header("location: account.php?login_success=You have successfully logged in");
    } else {
      header("location: login.php?error=Invalid email or password");
    }
  } else {
    header("location: login.php?error=Could not login. Please try again later");
  }
}

?>

<?php include("layouts/header.php"); ?>

<!-- Login -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="font-weight-bold">Login</h2>
    <hr class="mx-auto" />
  </div>

  <div class="mx-auto container">
    <form id="login-form" method="POST" action="login.php">
      <p style="color: red;"><?php if (isset($_GET['error'])) echo $_GET['error']; ?></p>
      <div class="form-group">
        <label for="login-email">Email</label>
        <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email" required />
      </div>

      <div class="form-group">
        <label for="login-password">Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required />
      </div>

      <div class="form-group">
        <button type="submit" id="login-btn" name="login_btn">Login</button>
      </div>

      <div class="form-group">
        <a id="register-url" href="register.php">
          Don't have an account? Register</a>
      </div>
    </form>
  </div>
</section>

<?php include("layouts/footer.php"); ?>