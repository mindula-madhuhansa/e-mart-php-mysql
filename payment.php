<?php

session_start();

if (isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}

?>

<?php include("layouts/header.php"); ?>

<!-- Payment -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Payment</h2>
        <hr class="mx-auto" />
    </div>

    <div class="mx-auto container text-center">
        <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
            <button type="submit">Pay Now</button>


        <?php } elseif (isset($_POST['order_status']) && $_POST['order_status'] == "Not Paid") { ?>
            <p>Total payment: $ <?php echo $order_total_price; ?></p>
            <button type="submit">Pay Now</button>
        <?php } else { ?>
            <p>Your cart is empty</p>
        <?php } ?>



    </div>
</section>

<?php include("layouts/footer.php"); ?>