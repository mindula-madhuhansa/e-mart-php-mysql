<?php include("layouts/header.php"); ?>

<!-- Home Section -->
<section id="home">
  <div class="container">
    <h5>NEW ARRIVALS</h5>
    <h1><span>Best Prices</span> For This Season</h1>
    <p>
      E-Mart offers the best prices for this season.<br />Get the best deals
      on our products.
    </p>
    <button>Shop Now</button>
  </div>
</section>

<!-- Brands Section -->
<section id="brand" class="container">
  <div class="row">
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/dior.png" alt="Dior" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/cartier.png" alt="Cartier" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/alo.png" alt="Alo" />
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/dyson.png" alt="Dyson" />
  </div>
</section>

<!-- New Section -->
<section id="new" class="w-100">
  <div class="row p-0 m-0">
    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/images/shoes.png" alt="Shoes" />
      <div class="details">
        <h2>Extreamly Awesome Shoes</h2>
        <button>Shop Now</button>
      </div>
    </div>

    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/images/handbag.png" alt="handbag" />
      <div class="details">
        <h2>Extreamly Awesome Handbag</h2>
        <button>Shop Now</button>
      </div>
    </div>

    <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/images/watch.png" alt="Watch" />
      <div class="details">
        <h2>Extreamly Awesome Watch</h2>
        <button>Shop Now</button>
      </div>
    </div>
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

<!-- Mid Banner -->
<section id="banner" class="my-5 py-5">
  <div class="container">
    <h4>SUMMER SALE IS HERE</h4>
    <h1>Get the best deals <br />on our products.</h1>
    <button>Shop Now</button>
  </div>
</section>

<!-- Clothes Section -->
<section id="clothes" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Casual Wears & Jackets</h3>
    <hr class="mx-auto" />
    <p>Here you can find our casual wears and jackets.</p>
  </div>

  <div class="row mx-auto container-fluid">
    <?php include("server/get_casual_wears.php"); ?>

    <?php while ($row = $casual_products->fetch_assoc()) { ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
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
        <button class="buy-btn">Buy Now</button>
      </div>


    <?php } ?>

  </div>
</section>

<!-- Shoes Section -->
<section id="shoes" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Shoes & Sneakers</h3>
    <hr class="mx-auto" />
    <p>Here you can find our shoes and sneakers.</p>
  </div>

  <div class="row mx-auto container-fluid">
    <?php include("server/get_shoes.php"); ?>

    <?php while ($row = $shoes_products->fetch_assoc()) { ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name">
          <?php echo $row['product_name']; ?>
        </h5>
        <h4 class="p-price">$<?php echo $row['product_price']; ?>
        </h4>
        <button class="buy-btn">Buy Now</button>
      </div>
    <?php } ?>



  </div>
</section>

<!-- Watches Section -->
<section id="watches" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Wrist Watches</h3>
    <hr class="mx-auto" />
    <p>Here you can find our wrist watches.</p>
  </div>

  <div class="row mx-auto container-fluid">
    <?php include("server/get_watches.php"); ?>

    <?php while ($row = $watches_products->fetch_assoc()) { ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
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
        <button class="buy-btn">Buy Now</button>
      </div>
    <?php } ?>

  </div>
</section>

<?php include("layouts/footer.php"); ?>