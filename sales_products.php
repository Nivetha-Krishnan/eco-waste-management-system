<?php
$conn = mysqli_connect("localhost","root","","myproject");

$result = mysqli_query($conn,"SELECT * FROM sales_products");
?>

<!DOCTYPE html>
<html>
<head>
<title>Sales Products</title>

<style>
body{
font-family:Arial;
background:linear-gradient(135deg,#a8e063,#56ab2f);
padding:30px;
}

h1{
text-align:center;
color:#145a32;
margin-bottom:30px;
}

.container{
display:flex;
flex-wrap:wrap;
gap:20px;
justify-content:center;
}

.card{
background:white;
width:260px;
border-radius:15px;
box-shadow:0 6px 18px rgba(0,0,0,0.2);
padding:20px;
text-align:center;
}

.card img{
width:150px;
height:150px;
object-fit:contain;
margin-bottom:10px;
}

.product{
font-weight:bold;
font-size:18px;
color:#145a32;
}

.price{
margin-top:6px;
}

.quantity{
margin-top:6px;
color:#c0392b;
font-weight:bold;
}

button{
margin-top:10px;
padding:8px 15px;
background:#2c7da0;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#1e6091;
}
</style>

</head>

<body>

<button onclick="location.href='salesdashboard.php'" 
style="margin-bottom:20px;padding:10px 15px;border:none;background:#2c7da0;color:white;border-radius:6px;">
⬅ Back
</button>

<h1>Products from Recycling</h1>

<div class="container">

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<div class="card">

<img src="<?php echo $row['product_image']; ?>">

<div class="product">
<?php echo $row['product_name']; ?>
</div>

<div class="price">
Price: ₹<?php echo $row['rate']; ?>
</div>

<div class="quantity">
Stock: <?php echo $row['quantity']; ?>
</div>


</div>

<?php } ?>

</div>

</body>
</html>