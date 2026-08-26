<!DOCTYPE html>
<html>
<head>
<title>Volunteer Dashboard</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

/* Background */
body{
    min-height:100vh;
    background:url('image4.jpg') no-repeat center center fixed;
    background-size:cover;
}

/* Overlay */
.overlay{
    min-height:100vh;
    background: rgba(0,0,0,0.6);
    display:flex;
}

/* Sidebar */
.sidebar{
    width:260px;
    background:#1f3d2b;
    color:white;
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
    text-align:center;
}

.sidebar a:hover{
    background:#246b45;
}

/* Main content */
.main{
    flex:1;
    padding:30px;
    color:white;
}

/* Top bar */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topbar h1{
    font-size:28px;
}

/* Cards */
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
    font-size:14px;
}
</style>
</head>

<body>

<div class="overlay">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Volunteer Panel</h2>
        <a href="volunteerdashboard.php">Dashboard</a>
        <a href="volunteer_register.php">Register</a>
        <a href="volunteer_assigned_work.php">Assigned Work</a>
        <a href="work_status.php">Work Status</a>
        <a href="volunteerlogout.php" style="background:#c0392b;">Logout</a>
        
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="topbar">
            <h1>Welcome Volunteer 👋</h1>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Volunteer Registration</h3>
                <p>Register yourself to participate in waste collection.</p>
            </div>

            <div class="card">
                <h3>Assigned Works</h3>
                <p>View works assigned by admin.</p>
            </div>

            <div class="card">
                <h3>Update Work Status</h3>
                <p>Mark assigned work as completed.</p>
            </div>
        </div>

    </div>

</div>

</body>
</html>

