<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
/* Same CSS from your previous dashboard (no changes) */
*{margin:0; padding:0; box-sizing:border-box; font-family:Arial;}
body{min-height:100vh; background:url('image10.jpg') no-repeat center center fixed; background-size:cover; color:white;}
.overlay{min-height:100vh; background: rgba(0,0,0,0.6); display:flex;}
.sidebar{width:260px; background:#1f3d2b; color:white; padding:20px;}
.sidebar h2{text-align:center; margin-bottom:30px; font-size:22px;}
.sidebar a{display:block; padding:12px 15px; margin-bottom:10px; color:white; text-decoration:none; border-radius:6px; background:#2e8b57;}
.sidebar a:hover{background:#246b45;}
.main{flex:1; padding:30px; color:white;}
.topbar{display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;}
.topbar h1{font-size:28px;}
.logout a{text-decoration:none; color:white; background:#c0392b; padding:8px 15px; border-radius:5px; font-weight:bold;}
.logout a:hover{background:#a93226;}
.cards{display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:20px;}
.card{background: rgba(255,255,255,0.95); color:#333; padding:25px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.4);}
.card h3{color:#2e8b57; margin-bottom:10px;}
.card p{font-size:14px;}
</style>
</head>
<body>
<div class="overlay">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admindashboard.php">Dashboard</a>
        <a href="admin_requests.php">View User Requests</a>
        <a href="admin_volunteers.php">Volunteer List</a>
        <a href="admin_assign.php">Assign Volunteers</a>
        <a href="admin_completed.php">Completed Requests</a>
        <a href="admin_feedback.php">Feedback</a>
        <a href="adminlogout.php" style="background:#c0392b;">Logout</a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="topbar">
            <h1>Admin Dashboard</h1>
            
        </div>

        <div class="cards">
            <div class="card">
                <h3>User Requests</h3>
                <p>View all waste collection requests sent by users.</p>
            </div>
            <div class="card">
                <h3>Assign Volunteers</h3>
                <p>Assign volunteers to approved waste requests.</p>
            </div>
            <div class="card">
                <h3>Volunteer List</h3>
                <p>View and manage available volunteers.</p>
            </div>
            <div class="card">
                <h3>Completed request</h3>
                <p>view only completed requests.</p>
            </div>
            <div class="card">
                <h3>User feedback</h3>
                <p>view customers feedback.</p>
</div>
        </div>
    </div>
</div>
</body>
</html>

