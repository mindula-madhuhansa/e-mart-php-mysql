<?php

session_start();

include("server/connection.php");

if (isset($_SESSION['logged_in'])) {
  header("location: account.php");
  exit();
}

if (isset($_POST['register'])) {
  $name =  $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm-password'];

  // check if password matches
  if ($password !== $confirm_password) {
    header("location: register.php?error=Password does not match");
  }

  // check if password is at least 6 characters long
  elseif (strlen($password) < 6) {
    header("location: register.php?error=Password must be at least 6 characters long");
  } else {
    // check if user already exists
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email = ?");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    if ($num_rows !== 0) {
      header("location: register.php?error=User already exists");
    } else {
      // create a new user
      $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");

      $stmt->bind_param("sss", $name, $email, md5($password));

      if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header("location: account.php?register_success=You have successfully registered");
      } else {
        header("location: register.php?error=Could not register user. Please try again later");
      }
    }
  }
}
?>

<?php include("layouts/header.php"); ?>

<!-- Register -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="font-weight-bold">Register</h2>
    <hr class="mx-auto" />
  </div>

  <div class="mx-auto container">
    <form id="register-form" method="POST" action="register.php">
      <p style="color: red;"><?php if (isset($_GET['error'])) echo $_GET['error']; ?></p>
      <div class="form-group">
        <label for="register-name">Name</label>
        <input type="text" class="form-control" id="register-name" name="name" placeholder="Enter your full name" required />
      </div>

      <div class="form-group">
        <label for="register-email">Email</label>
        <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter your email" required />
      </div>

      <div class="form-group">
        <label for="register-password">Password</label>
        <input type="password" class="form-control" id="register-password" name="password" placeholder="Enter your password" required />
      </div>

      <div class="form-group">
        <label for="register-confirm-password">Confirm Password</label>
        <input type="password" class="form-control" id="register-confirm-password" name="confirm-password" placeholder="Enter your password again" required />
      </div>

      <div class="form-group">
        <button type="submit" id="register-btn" name="register">Register</button>
      </div>

      <div class="form-group">
        <a id="register-url" href="login.php">
          Already have an account? Login
        </a>
      </div>
    </form>
  </div>
</section>

<?php include("layouts/footer.php"); ?>