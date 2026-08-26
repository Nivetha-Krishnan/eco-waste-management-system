<?php
session_start();

// Check if recycle team is logged in
if(!isset($_SESSION['recycle_id'])){
    header("Location: recyclelogin.php");
    exit();
}

$username = $_SESSION['recycle_username'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Recycle Dashboard</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}

/* Body & Overlay */
body{min-height:100vh;background:#f2f2f2;color:white;}
.overlay{min-height:100vh;background: rgba(0,0,0,0.6);display:flex;}

/* Sidebar */
.sidebar{width:260px;background:#1f3d2b;padding:20px;}
.sidebar h2{text-align:center;margin-bottom:30px;font-size:22px;}
.sidebar a{display:block;padding:12px 15px;margin-bottom:10px;color:white;text-decoration:none;border-radius:6px;background:#2e8b57;font-weight:bold;text-align:center;transition:0.3s;}
.sidebar a:hover{background:#246b45;}
.sidebar .logout{background:#c0392b;}
.sidebar .logout:hover{background:#a8322a;}

/* Main content */
.main{flex:1;padding:30px;color:white;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.topbar h1{font-size:28px;}

/* Top images */
.top-images{display:flex;justify-content:space-between;margin-bottom:30px;}
.top-images img{width:48%;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.3);}

/* Cards */
.cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.card{background: rgba(255,255,255,0.95);color:#333;padding:25px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.4);}
.card h3{color:#2e8b57;margin-bottom:10px;}
.card p{font-size:14px;}
</style>
</head>
<body>

<div class="overlay">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Recycle Team</h2>
        <a href="recycledashboard.php">Dashboard</a>
        <a href="received_waste.php"> Waste list</a> 
        <a href="recycle_process.php">Recycle process</a>
        <a href="recycled_products.php">Recycled Products</a>
        <a href="recyclelogout.php" class="logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
            <h1>Welcome, <?php echo $username; ?> 👋</h1>
        </div>

        <!-- Top images -->
        <div class="top-images">
            <img src="image8.jpg" alt="Recycle Image 1">
            <img src="image9.jpg" alt="Recycle Image 2">
        </div>

        <!-- Dashboard cards -->
        <div class="cards">
            <div class="card">
                <h3>Assigned Recycled Waste</h3>
                <p>View waste collected and assigned to your team for recycling.</p>
            </div>
            <div class="card">
                <h3>Add Recycled Products</h3>
                <p>Convert collected waste into recycled products and add quantity.</p>
            </div>
            <div class="card">
                <h3>Inventory Management</h3>
                <p>Check your recycled products stock and manage inventory.</p>
            </div>
            <div class="card">
                <h3>Sales Module</h3>
                <p>Send recycled products to sales or view product demand.</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>
