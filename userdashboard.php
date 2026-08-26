<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: userlogin.php");
    exit();
}
$username = $_SESSION['user'];

// Database connection
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn) die("DB Connection Failed");

// Check if user has completed requests without feedback
$user_feedback_ready = mysqli_query($conn, "
    SELECT * FROM waste_requests 
    WHERE username='$username' AND status='Collected' AND feedback_status='Pending'
");
$feedback_available = mysqli_num_rows($user_feedback_ready) > 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<style>
*{margin:0; padding:0; box-sizing:border-box; font-family:Arial;}
body{
    min-height:100vh;
    background:url('image5.jpg') no-repeat center center fixed;
    background-size:cover;
    color:white;
}
.overlay{
    min-height:100vh;
    background: rgba(0,0,0,0.6);
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#1f3d2b;
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
    background:#2e8b57;
    font-weight:bold;
}
.sidebar a:hover{
    background:#246b45;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.topbar h1{
    font-size:28px;
}
.cards{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
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
    color:#2e8b57;
    margin-bottom:10px;
}
.card p{
    color:#333;
}
.feedback-alert{
    background:#ffeb3b;
    color:#333;
    padding:12px;
    border-radius:8px;
    text-align:center;
    font-weight:bold;
    margin-bottom:20px;
}
.feedback-alert a{
    color:#2e8b57;
    font-weight:bold;
    text-decoration:none;
}
.feedback-alert a:hover{
    text-decoration:underline;
}
</style>
</head>
<body>

<div class="overlay">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>User Panel</h2>
        <a href="userdashboard.php">Dashboard</a>
        <a href="user_waste_requests.php">Waste Request</a>
        <a href="user_requests_status.php">Your Requests</a>
        <?php if($feedback_available): ?>
            <a href="submit_feedback.php" style="background:#f39c12;">Submit Feedback</a>
        <?php else: ?>
            <a href="submit_feedback.php">Feedback</a>
        <?php endif; ?>
        <a href="userlogout.php" style="background:#c0392b;">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="topbar">
            <h1>Welcome, <?php echo $username; ?> 👋</h1>
        </div>

        <?php if($feedback_available): ?>
            <div class="feedback-alert">
                🎉 You have completed requests! <a href="submit_feedback.php">Submit your feedback now</a>.
            </div>
        <?php endif; ?>

        <div class="cards">
            <div class="card">
                <h3>Request Waste Collection</h3>
                <p>Submit a new waste pickup request easily.</p>
            </div>
            <div class="card">
                <h3>Track Requests</h3>
                <p>Check status of your submitted requests.</p>
            </div>
            <div class="card">
                <h3>User Feedback</h3>
                <p>Share your experience once your waste request is completed.</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>
