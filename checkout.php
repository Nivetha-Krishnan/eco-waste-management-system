<?php
$conn = mysqli_connect("localhost","root","","myproject");

$id = $_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM sales_products WHERE product_id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>
body{
font-family:Arial;
background:linear-gradient(135deg,#a8e063,#56ab2f);
padding:20px;
}

.box{
width:350px;
margin:auto;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

input{
width:100%;
padding:10px;
margin-top:10px;
border:1px solid #ccc;
border-radius:6px;
}

button{
width:100%;
padding:10px;
margin-top:15px;
background:#2c7da0;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

h3{
text-align:center;
color:#145a32;
}
</style>
</head>

<body>

<div class="box">

<h3>🛒 Delivery Details</h3>

<p><b>Product:</b> <?php echo $row['product_name']; ?></p>
<p><b>Price:</b> ₹<?php echo $row['rate']; ?></p>

<form action="payment.php" method="POST">

<input type="hidden" name="product" value="<?php echo $row['product_name']; ?>">
<input type="hidden" name="price" value="<?php echo $row['rate']; ?>">

<input type="text" name="name" placeholder="Full Name" required>

<input type="text" name="door" placeholder="Door No" required>

<input type="text" name="street" placeholder="Street Name" required>

<input type="text" name="district" placeholder="District" required>

<button type="submit">Continue to Payment</button>

</form>

</div>

</body>
</html>