<?php
$conn = mysqli_connect("localhost","root","","myproject");

$name = $_POST['name'];
$door = $_POST['door'];
$street = $_POST['street'];
$district = $_POST['district'];
$product = $_POST['product'];
$price = $_POST['price'];
$payment = $_POST['payment'];

/* 1. product stock reduce */
$get = mysqli_query($conn,"SELECT * FROM sales_products WHERE product_name='$product'");
$row = mysqli_fetch_assoc($get);

$newStock = $row['quantity'] - 1;

mysqli_query($conn,"UPDATE sales_products SET quantity=$newStock WHERE product_name='$product'");

/* 2. order save */
mysqli_query($conn,"INSERT INTO orders 
(product_id,product_name,price,customer_name,door,street,district,payment)
VALUES
('{$row['product_id']}','$product','$price','$name','$door','$street','$district','$payment')");

?>

<!DOCTYPE html>
<html>
<head>
<title>Success</title>

<style>
    
body{
font-family:Arial;
background:#e8f5e9;
text-align:center;
padding:40px;
}

.box{
background:white;
display:inline-block;
padding:30px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
}
</style>
</head>

<body>
<button class="back-btn" onclick="window.location.href='salesdashboard.php'">⬅ Back</button>


<div class="box">

<h1>🎉 Order Placed!</h1>
<h1>Delivered soon!</h1>
<p>Product: <?php echo $product; ?></p>

</div>

</body>
</html>