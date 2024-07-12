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

<?php include("layouts/header.php"); ?>

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

<?php include("layouts/footer.php"); ?>