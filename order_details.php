<?php

include("server/connection.php");

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");

    $stmt->bind_param("i", $order_id);

    $stmt->execute();

    $order_details = $stmt->get_result();
} else {
    header("location: account.php");
    exit();
}

?>

<?php include("layouts/header.php"); ?>

<!-- Order Details -->
<section id="orders" class="orders container my-5 py-3">
    <div class="container mt-5">
        <h2 class="text-center font-weight-bold">Order Details</h2>
        <hr class="mx-auto" />
    </div>

    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>

        <?php while ($order = $order_details->fetch_assoc()) { ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/images/<?php echo $order['product_image'] ?>" alt="<?php echo $order['product_name'] ?>" />
                        <div>
                            <p class="mt-3"><?php echo $order['product_name'] ?></p>
                        </div>
                    </div>
                </td>

                <td>
                    <span>$<?php echo $order['product_price'] ?></span>
                </td>

                <td>
                    <span><?php echo $order['product_quantity'] ?></span>
                </td>


            </tr>
        <?php } ?>

    </table>

    <?php if ($order_status == 'Not Paid') { ?>
        <form style="float: right;">
            <button type="submit" class="pay_now_btn">Pay Now</button>
        </form>

    <?php }  ?>
</section>

<?php include("layouts/footer.php"); ?>