<?php
include("connection.php");

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='casual' LIMIT 4 ");

$stmt->execute();

$casual_products = $stmt->get_result();
