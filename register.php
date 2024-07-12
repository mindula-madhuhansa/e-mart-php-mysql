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


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop</title>
  <link rel="icon" type="image/svg+xml" href="assets/images/logo.svg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-light navbar-expand-lg bg-white py-3 fixed-top">
    <div class="container">
      <a href="index.php" class="d-flex align-items-center text-decoration-none"><img class="logo" src="assets/images/logo.svg" alt="logo" />
        <h2 class="brand">E-Mart</h2>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.html">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact Us</a>
          </li>

          <li class="nav-item">
            <a href="cart.php"><i class="fas fa-shopping-bag"></i></a>
            <a href="account.php"><i class="fas fa-user"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

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

  <!-- Footer -->
  <footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <img class="logo" src="assets/images/logo.svg" alt="logo" />
        <p class="pt-3">
          E-Mart offers the best prices for this season.<br />Get the best
          deals on our products.
        </p>
      </div>

      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Featured</h5>
        <ul class="text-uppercase">
          <li><a href="#">Men</a></li>
          <li><a href="#">Women</a></li>
          <li><a href="#">Kids</a></li>
          <li><a href="#">New Arrivals</a></li>
          <li><a href="#">Clothes</a></li>
        </ul>
      </div>

      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Contact Us</h5>
        <div>
          <h6 class="text-uppercase">Address</h6>
          <p>123, Main Street, New York, USA</p>
        </div>
        <div>
          <h6 class="text-uppercase">Contact Number</h6>
          <p>123 456 7890</p>
        </div>
        <div>
          <h6 class="text-uppercase">Email</h6>
          <p>info@emart.com</p>
        </div>
      </div>

      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Instagram</h5>
        <div class="row">
          <img src="assets/images/featured1.png" alt="Footer 1" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/images/featured2.png" alt="Footer 1" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/images/featured3.png" alt="Footer 1" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/images/featured4.png" alt="Footer 1" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/images/clothes1.png" alt="Footer 1" class="img-fluid w-25 h-100 m-2" />
        </div>
      </div>
    </div>

    <div class="copyright mt-5">
      <div class="row container mx-auto">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <img src="assets/images/payment.png" alt="Payment" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4 text-nowrap mb-2">
          <p>&copy; 2024 E-Mart. All Rights Reserved.</p>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <a href="#"><i class="fab fa-facebook"></i> </a>
          <a href="#"><i class="fab fa-instagram"></i> </a>
          <a href="#"><i class="fab fa-twitter"></i> </a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>