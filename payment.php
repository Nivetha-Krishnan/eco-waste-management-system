<?php
$name = $_POST['name'];
$door = $_POST['door'];
$street = $_POST['street'];
$district = $_POST['district'];
$product = $_POST['product'];
$price = $_POST['price'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>

<style>
body{
font-family:Arial;
background:#f1f8e9;
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

button{
margin-top:15px;
padding:10px 20px;
background:green;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}
</style>
</head>

<body>
    

<div class="box">

<h2>💳 Fake Payment Page</h2>

<p><b>Product:</b> <?php echo $product; ?></p>
<p><b>Amount:</b> ₹<?php echo $price; ?></p>

<p>Choose Payment Method:</p>

<form action="success.php" method="POST">

<input type="hidden" name="name" value="<?php echo $name; ?>">
<input type="hidden" name="door" value="<?php echo $door; ?>">
<input type="hidden" name="street" value="<?php echo $street; ?>">
<input type="hidden" name="district" value="<?php echo $district; ?>">
<input type="hidden" name="product" value="<?php echo $product; ?>">
<input type="hidden" name="price" value="<?php echo $price; ?>">

<label>
<input type="radio" name="payment" value="COD" required>
Cash on Delivery
</label>

<br><br>

<label>
<input type="radio" name="payment" value="UPI">
UPI 
</label>

<br><br>

<button type="submit">Pay Now</button>

</form>

</div>

</body>
</html>