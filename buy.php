<?php
$conn = mysqli_connect("localhost","root","","myproject");

$id = $_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM sales_products WHERE product_id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Buy Product</title>
<style>
body{
font-family:Arial;
background:#f1f8e9;
text-align:center;
padding:30px;
}

.card{
background:white;
display:inline-block;
padding:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

img{
width:150px;
height:150px;
object-fit:contain;
}

button{
margin-top:15px;
padding:10px 20px;
background:#2c7da0;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}
</style>
</head>

<body>

<h1>Confirm Product</h1>

<div class="card">
<img src="<?php echo $row['product_image']; ?>">
<h3><?php echo $row['product_name']; ?></h3>
<p>Price: ₹<?php echo $row['rate']; ?></p>

<a href="checkout.php?id=<?php echo $row['product_id']; ?>">
    <button>Proceed to Buy</button>
</a>

</div>

</body>
</html>