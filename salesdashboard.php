<?php
session_start();

// Check if sales team logged in
if(!isset($_SESSION['sales_id'])){
    header("Location: sales_login.php");
    exit();
}

$username = $_SESSION['sales_username'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Sales Dashboard</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}

/* Body */
body{min-height:100vh;background:#f2f2f2;color:white;}
.overlay{min-height:100vh;background: rgba(0,0,0,0.6);display:flex;}

/* Sidebar */
.sidebar{
width:260px;
background:#1b3a4b;
padding:20px;
}

.sidebar h2{
text-align:center;
margin-bottom:30px;
font-size:22px;
}

.sidebar a{
display:block;
padding:12px 15px;
margin-bottom:10px;
color:white;
text-decoration:none;
border-radius:6px;
background:#2c7da0;
font-weight:bold;
text-align:center;
transition:0.3s;
}

.sidebar a:hover{
background:#1e6091;
}

.sidebar .logout{
background:#c0392b;
}

.sidebar .logout:hover{
background:#a8322a;
}

/* Main content */
.main{
flex:1;
padding:30px;
color:white;
}

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.topbar h1{
font-size:28px;
}

/* Single image */
.top-image{
text-align:center;
margin-bottom:30px;
}

.top-image img{
width:60%;
border-radius:12px;
box-shadow:0 4px 15px rgba(0,0,0,0.3);
}

/* Cards */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

.card{
background: rgba(255,255,255,0.95);
color:#333;
padding:25px;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,0.4);
}

.card h3{
color:#2c7da0;
margin-bottom:10px;
}

.card p{
font-size:14px;
}

</style>
</head>

<body>

<div class="overlay">

<!-- Sidebar -->
<div class="sidebar">
<h2>Sales Team</h2>

<a href="salesdashboard.php">Dashboard</a>
<a href="sales_products.php">Products from Recycling</a>
<a href="buy_products.php">Buyproducts</a>
<a href="orders.php">Customer Orders</a>
<a href="saleslogout.php" class="logout">Logout</a>
</div>

<!-- Main -->
<div class="main">

<div class="topbar">
<h1>Welcome, <?php echo $username; ?> 👋</h1>
</div>

<!-- One Image -->
<div class="top-image">
<img src="image11.jpg" alt="sales image">
</div>

<!-- Cards -->
<div class="cards">

<div class="card">
<h3>Recycled Products</h3>
<p>View products received from recycling team.</p>
</div>

<div class="card">
<h3>Inventory</h3>
<p>Check available stock of recycled products.</p>
</div>

<div class="card">
<h3>Orders</h3>
<p>Manage customer orders and delivery.</p>
</div>

<div class="card">
<h3>Sales Report</h3>
<p>Track recycled product sales and revenue.</p>
</div>

</div>

</div>

</div>

</body>
</html>