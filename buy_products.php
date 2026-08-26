<?php
$conn = mysqli_connect("localhost","root","","myproject");

$result = mysqli_query($conn,"SELECT * FROM sales_products");

function getCategory($name){

    $name = strtolower($name);

    if(strpos($name,"fertilizer") !== false ||
       strpos($name,"compost") !== false ||
       strpos($name,"cowdung") !== false ||
       strpos($name,"vermi") !== false){
        return "🌱 Garden Composts";
    }

    else if(strpos($name,"pot") !== false ||
            strpos($name,"chair") !== false ||
            strpos($name,"toy") !== false ||
            strpos($name,"pillow") !== false ||
            strpos($name,"basket") !== false ||
            strpos($name,"lantern") !== false ||
            strpos($name,"doormat") !== false ||
            strpos($name,"cap") !== false ||
            strpos($name,"sofa cover") !== false ||
            strpos($name,"handbag") !== false ||
            strpos($name,"vessel") !== false ||
            strpos($name,"jewel container") !== false ||
            strpos($name,"grassmat") !== false ||
            strpos($name,"purse") !== false ||
            strpos($name,"fruit bowl") !== false ||
            strpos($name,"dyecolor") !== false ||
            strpos($name,"statinary items holder") !== false ||
            strpos($name,"child cycle") !== false ||
            strpos($name,"lamp") !== false ||
            strpos($name,"table") !== false){
        return "🏡 Household Products";
    }

    else if(strpos($name,"fence") !== false ||
            strpos($name,"growbag") !== false ||
            strpos($name,"animal") !== false ||
            strpos($name,"mulch") !== false ||
            strpos($name,"feed") !== false){
        return "🌿 Garden Products";
    }

    else if(strpos($name,"wire") !== false ||
            strpos($name,"zinc") !== false ||
            strpos($name,"electronic") !== false ||
            strpos($name,"steel") !== false ||
            strpos($name,"copper") !== false ||
            strpos($name,"plastic") !== false){
        return "⚡ E Products";
    }

    else if(strpos($name,"vase") !== false ||
            strpos($name,"frame") !== false ||
            strpos($name,"decor") !== false ||
            strpos($name,"showpiece") !== false ||
            strpos($name,"candle holder") !== false ||
            strpos($name,"piggybank") !== false ||
            strpos($name,"lampshade") !== false ||
            strpos($name,"wall") !== false){
        return "🏠 Home Decor";
    }

    else{
        return "📦 Others";
    }
}

$groups = [
    "🌱 Garden Composts" => [],
    "🏡 Household Products" => [],
    "🌿 Garden Products" => [],
    "⚡ E Products" => [],
    "🏠 Home Decor" => [],
    "📦 Others" => []
];

while($row = mysqli_fetch_assoc($result)){
    $cat = getCategory($row['product_name']);
    $groups[$cat][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Buy Products</title>

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

h2{
margin-top:40px;
color:#0b3d2e;
border-left:6px solid #2c7da0;
padding-left:10px;
}

.container{
display:flex;
flex-wrap:wrap;
gap:20px;
margin-top:15px;
justify-content:center;
}

.card{
background:white;
width:220px;
border-radius:15px;
box-shadow:0 6px 18px rgba(0,0,0,0.2);
padding:15px;
text-align:center;
transition:0.3s;
}

.card:hover{
transform:scale(1.05);
}

.card img{
width:120px;
height:120px;
object-fit:contain;
}

.product{
font-weight:bold;
margin-top:8px;
font-size:15px;
}

.price{
color:#2c7da0;
margin-top:5px;
}

.stock{
color:#c0392b;
font-weight:bold;
margin-top:5px;
}

button{
margin-top:8px;
padding:8px 12px;
border:none;
background:#2c7da0;
color:white;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#1e6091;
}

</style>
</head>

<body>

<button onclick="location.href='salesdashboard.php'">
⬅ Back
</button>

<h1>🛒 Buy Products</h1>

<?php foreach($groups as $category => $items){ ?>

<h2><?php echo $category; ?></h2>

<div class="container">

<?php foreach($items as $p){ ?>

<div class="card">

    <img src="<?php echo $p['product_image']; ?>">

    <div class="product">
        <?php echo $p['product_name']; ?>
    </div>

    <div class="price">
        ₹<?php echo $p['rate']; ?>
    </div>

    <div class="stock">
        Stock: <?php echo $p['quantity']; ?>
    </div>

    <!-- ✅ BUY BUTTON ADDED -->
    <a href="buy.php?id=<?php echo $p['product_id']; ?>">
        <button>Buy Now</button>
    </a>

</div>

<?php } ?>

</div>

<?php } ?>

</body>
</html>