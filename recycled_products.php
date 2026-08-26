<?php
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
die("Connection Failed");
}

$q = mysqli_query($conn,"SELECT * FROM recycling_products ORDER BY category");
$current_category = "";
?>

<!DOCTYPE html>
<html>
<head>
<title>Recycled Products</title>

<style>

body{
font-family:Segoe UI;
background:linear-gradient(135deg,#d4fc79,#96e6a1);
padding:30px;
}

h1{
text-align:center;
color:#145a32;
margin-bottom:30px;
}

.category-title{
font-size:26px;
font-weight:bold;
color:#145a32;
margin-top:40px;
margin-bottom:20px;
border-left:6px solid #1e8449;
padding-left:10px;
}

.container{
display:flex;
flex-wrap:wrap;
gap:25px;
}

.card{
background:#ecfdf5;
width:260px;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,0.2);
padding:18px;
text-align:center;
transition:0.3s;
}

.card:hover{
transform:translateY(-6px);
}

.card img{
width:160px;
height:160px;
object-fit:contain;
margin-bottom:12px;
}

.waste{
font-size:16px;
font-weight:bold;
color:#145a32;
}

.process{
font-size:14px;
color:#555;
margin-top:5px;
}

.product{
font-weight:bold;
color:#1e8449;
margin-top:8px;
}

.btn{
margin-top:12px;
padding:8px 14px;
background:#28b463;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

.btn:hover{
background:#1d8348;
}

</style>
</head>

<body>
    <button class="back-btn" onclick="location.href='recycledashboard.php'">⬅ Back</button>


<h1>♻ Recycled Products</h1>

<?php
while($row=mysqli_fetch_assoc($q)){

if($current_category != $row['category']){

if($current_category != ""){
echo "</div>";
}

$current_category = $row['category'];

echo "<div class='category-title'>$current_category</div>";
echo "<div class='container'>";
}

$productImg = "images/product/".str_replace(' ','',$row['product']).".png";
?>

<div class="card">

<img src="<?php echo $productImg; ?>">

<div class="waste"><?php echo $row['wastetype']; ?></div>

<div class="process"><?php echo $row['process']; ?></div>

<div class="product"><?php echo $row['product']; ?></div>

<form method="POST" action="send_to_sales.php">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">  <!-- ADD THIS -->

<input type="hidden" name="product" value="<?php echo $row['product']; ?>">
<input type="hidden" name="image" value="<?php echo $productImg; ?>">

<button class="btn">Send to Sales Module</button>

</form>

</div>

<?php } ?>

</div>

</body>
</html>
