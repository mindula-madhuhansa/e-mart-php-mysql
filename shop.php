<?php

include("server/connection.php");

if (isset($_POST['search'])) {
  $category = $_POST['category'];
  $price = $_POST['price'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ?");
  $stmt->bind_param("si", $category, $price);
  $stmt->execute();
  $products = $stmt->get_result();
} else {
  $stmt = $conn->prepare("SELECT * FROM products");
  $stmt->execute();
  $products = $stmt->get_result();
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

  <style>
    .product img {
      width: 100%;
      height: auto;
      box-sizing: border-box;
      object-fit: cover;
    }

    .pagination a {
      color: coral;
    }

    .pagination li:hover a {
      background-color: coral;
      color: #fff;
    }
  </style>
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
            <a class="nav-link" href="shop.php">Shop</a>
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

  <!-- Main Section -->
  <section id="main" class="container py-5 mt-5">
    <div class="row">
      <!-- Search Section -->
      <div id="search" class="col-lg-3 col-md-4 col-sm-12">
        <div class="mt-5 py-5">
          <p>Search Products</p>
          <hr />
        </div>
        <form method="POST" action="shop.php">
          <div class="mb-4">
            <p>Category</p>
            <div class="form-check">
              <input class="form-check-input" value="casual" type="radio" name="category" id="category_one" checked />
              <label class="form-check-label" for="category_one">Casual Wears</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" value="shoes" type="radio" name="category" id="category_two" />
              <label class="form-check-label" for="category_two">Shoes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" value="watches" type="radio" name="category" id="category_three" />
              <label class="form-check-label" for="category_three">Watches</label>
            </div>
          </div>
          <div class="mb-4">
            <p>Price Range</p>
            <input type="range" name="price" class="form-range" value="100" min="1" max="1000" id="customRange2" />
            <div class="d-flex justify-content-between">
              <span>1</span>
              <span>1000</span>
            </div>
          </div>
          <div class="form-group my-3">
            <button type="submit" name="search">
              Search
            </button>
          </div>
        </form>
      </div>

      <!-- Products Section -->
      <div id="feature" class="col-lg-9 col-md-8 col-sm-12 my-5 py-5">
        <div class="container">
          <h3>Our Products</h3>
          <hr />
          <p>Here you can find our products.</p>
        </div>

        <div class="row">
          <?php while ($row = $products->fetch_assoc()) { ?>
            <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id'] ?>;'" class="product text-center col-lg-3 col-md-4 col-sm-12">
              <img class="img-fluid mb-3" src="assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" />
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
              <h4 class="p-price">$<?php echo $row['product_price']; ?></h4>
            </div>
          <?php } ?>

          <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="#">Previous</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
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