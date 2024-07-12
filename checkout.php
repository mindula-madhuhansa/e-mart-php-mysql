<?php
session_start();

if (!empty($_SESSION['cart'])) {
} else {
  header('location: index.php');
}

?>

<?php include("layouts/header.php"); ?>

<!-- Checkout -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="font-weight-bold">Checkout</h2>
    <hr class="mx-auto" />
  </div>

  <div class="mx-auto container">
    <form id="checkout-form" method="POST" action="server/place_order.php">
      <div class="form-group checkout-small-element">
        <label for="checkout-name">Name</label>
        <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Enter your full name" required />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-email">Email</label>
        <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Enter your email" required />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-phone">Phone Number</label>
        <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Enter your phone number" required />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-city">City</label>
        <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Enter your city" required />
      </div>

      <div class="form-group checkout-large-element">
        <label for="checkout-address">Address</label>
        <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Enter your address" required />
      </div>

      <div class="form-group checkout-btn-container">
        <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
        <button type="submit" name="place_order" id="checkout-btn">Place Order</button>
      </div>
    </form>
  </div>
</section>

<?php include("layouts/footer.php"); ?>