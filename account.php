<?php
session_start();

include("server/connection.php");

if (!isset($_SESSION['logged_in'])) {
  header("location: login.php");
  exit();
}

if (isset($_GET['logout'])) {
  if (isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    header("location: login.php");
    exit();
  }
}

if (isset($_POST['change_password'])) {
  $password = ($_POST['password']);
  $confirm_password = ($_POST['confirm_password']);
  $email = $_SESSION['user_email'];


  // check if password matches
  if ($password !== $confirm_password) {
    header("location: account.php?error=Password does not match");
  }

  // check if password is at least 6 characters long
  elseif (strlen($password) < 6) {
    header("location: account.php?error=Password must be at least 6 characters long");
  } else {
    $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");

    $stmt->bind_param("ss", md5($password), $email);

    if ($stmt->execute()) {
      header("location: account.php?message=Password changed successfully");
    } else {
      header("location: account.php?error=Could not change password. Please try again later");
    }
  }
}

// get orders
if (isset($_SESSION['logged_in'])) {
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");

  $stmt->bind_param("i", $_SESSION['user_id']);

  $stmt->execute();

  $orders = $stmt->get_result();
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

  <!-- Account-->
  <section class="my-5 py-5">
    <div class="container row mx-auto">
      <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
        <p class="text-center" style="color: green;"><?php if (isset($_GET['register_success'])) echo $_GET['register_success']; ?></p>
        <p class="text-center" style="color: green;"><?php if (isset($_GET['login_success'])) echo $_GET['login_success']; ?></p>
        <h3 class="font-weight-bold">Account Info</h3>
        <hr class="mx-auto" />

        <div class="account-info">
          <p>Name: <span><?php if (isset($_SESSION['user_name'])) echo $_SESSION['user_name']; ?></span></p>
          <p>Email: <span><?php if (isset($_SESSION['user_email'])) echo $_SESSION['user_email']; ?></span></p>
          <p><a href="#orders" id="order-btn">Your orders</a></p>
          <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
        </div>
      </div>

      <div class="col-lg-6 col-md-12 col-sm-12">
        <form id="account-form" method="POST" action="account.php">
          <p class="text-center" style="color: red;"><?php if (isset($_GET['error'])) echo $_GET['error']; ?></p>
          <p class="text-center" style="color: green;"><?php if (isset($_GET['message'])) echo $_GET['message']; ?></p>
          <h3>Change password</h3>
          <hr class="mx-auto" />
          <div class="form-group">
            <label for="account-password">Password</label>
            <input type="password" class="form-control" id="account-password" name="password" placeholder="Enter your new password" required />
          </div>

          <div class="form-group">
            <label for="account-confirm-password">Confirm Password</label>
            <input type="password" class="form-control" id="account-confirm-password" name="confirm_password" placeholder="Confirm your new password" required />
          </div>

          <div class="form-group">
            <button type="submit" name="change_password" id="change-password-btn">
              Change Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Orders Section -->
  <section id="orders" class="orders container my-5 py-3">
    <div class="container mt-2">
      <h2 class="text-center font-weight-bold">Your Orders</h2>
      <hr class="mx-auto" />
    </div>

    <table class="mt-5 pt-5">
      <tr>
        <th>Order ID</th>
        <th>Order Cost</th>
        <th>Order Status</th>
        <th>Order Date</th>
        <th>Order Details</th>
      </tr>

      <?php while ($order = $orders->fetch_assoc()) { ?>
        <tr>
          <td>
            <span><?php echo $order['order_id']; ?></span>
          </td>

          <td>
            <span>$<?php echo $order['order_cost']; ?></span>
          </td>

          <td>
            <span><?php echo $order['order_status']; ?></span>
          </td>

          <td>
            <span> <?php echo $order['order_date']; ?></span>
          </td>

          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>" />
              <input type="hidden" name="order_status" value="<?php echo $order['order_status']; ?>" />
              <input type="submit" name="order_details_btn" value="View" />
            </form>
          </td>
        </tr>
      <?php } ?>

    </table>
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