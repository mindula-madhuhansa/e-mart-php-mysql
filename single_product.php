<?php

include('server/connection.php');

if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);

  $stmt->execute();

  $product = $stmt->get_result();
}
?>

<?php include("layouts/header.php"); ?>

<!-- Single Product Details -->
<section class="container single-product my-5 pt-5">
  <div class="row mt-5">

    <?php while ($row = $product->fetch_assoc()) { ?>
      <div class="col-lg-5 col-md-6 col-sm-12">
        <img id="mainImg" src="assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="img-fluid w-100 pb-1" />
        <div class="small-img-group">
          <div class="small-img-col">
            <img src="assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" width="100%" class="small-img" />
          </div>
          <div class="small-img-col">
            <img src="assets/images/<?php echo $row['product_image2']; ?>" alt="<?php echo $row['product_name']; ?>" width="100%" class="small-img" />
          </div>
          <div class="small-img-col">
            <img src="assets/images/<?php echo $row['product_image3']; ?>" alt="<?php echo $row['product_name']; ?>" width="100%" class="small-img" />
          </div>
          <div class="small-img-col">
            <img src="assets/images/<?php echo $row['product_image4']; ?>" alt="<?php echo $row['product_name']; ?>" width="100%" class="small-img" />
          </div>
        </div>
      </div>


      <div class="col-lg-6 col-md-12 col-sm-12">
        <h6 class="text-capitalize"><?php echo $row['product_category']; ?></h6>
        <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
        <h2>$<?php echo $row['product_price']; ?></h2>

        <form method="POST" action="cart.php">
          <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>" />
          <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>" />
          <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>" />
          <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>" />
          <input type="number" name="product_quantity" value="1" />
          <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
        </form>

        <h4 class="my-5">Product Details</h4>
        <span>
          <?php echo $row['product_description']; ?>
        </span>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Featured Section -->
<section id="featured" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Our Featured Products</h3>
    <hr class="mx-auto" />
    <p>Here you can find our featured products.</p>
  </div>

  <div class="row mx-auto container-fluid">
    <?php include("server/get_featured_products.php"); ?>

    <?php while ($row = $featured_products->fetch_assoc()) { ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/<?php echo $row["product_image"]; ?>" alt="<?php echo $row["product_name"]; ?>" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name'] ?></h5>
        <h4 class="p-price">$<?php echo $row['product_price'] ?></h4>
        <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
      </div>

    <?php } ?>
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

<script>
  var mainImg = document.getElementById("mainImg");
  var smallImg = document.getElementsByClassName("small-img");

  for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() {
      mainImg.src = smallImg[i].src;
    };
  }
</script>

<?php include("layouts/footer.php"); ?>