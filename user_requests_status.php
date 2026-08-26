<?php
session_start();

// Check login
if(!isset($_SESSION['user'])) { 
    header("Location: userlogin.php"); 
    exit(); 
}

$username = $_SESSION['user'];

// DB connection
$conn = mysqli_connect("localhost","root","","myproject");

if(!$conn){
    die("DB connection failed: ".mysqli_connect_error());
}

// Query
$sql = "SELECT * FROM waste_requests WHERE username='$username' ORDER BY id DESC";
$res = mysqli_query($conn, $sql);

if(!$res){
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Requests</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f0f5f0;
    padding:20px;
}

.main-content{
    width:90%;
    max-width:900px;
    margin:50px auto;
    padding:20px;
    background:white;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}

h2{
    text-align:center;
    color:#2e8b57;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th,td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

th{
    background:#2e8b57;
    color:white;
}

.locked{
    color:green;
    font-weight:bold;
}

.back-btn{
    background:#2e8b57;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:5px;
    cursor:pointer;
}

.back-btn:hover{
    background:#256d45;
}
</style>
</head>

<body>

<div class="main-content">

<button class="back-btn" onclick="window.location.href='userdashboard.php'">⬅ Back</button>

<h2>Your Requests</h2>

<table>
<tr>
<th>Person Name</th>
<th>Address</th>
<th>Waste Details</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>

<?php
if(mysqli_num_rows($res) == 0){
    echo "<tr><td colspan='6'>No Requests Found</td></tr>";
}
else{
    while($row = mysqli_fetch_assoc($res)){
        
        $status = $row['status'];

        if($status == "Completed"){
            $status_html = "<span class='locked'>Completed</span>";
        } else {
            $status_html = $status;
        }

        echo "<tr>
        <td>".$row['person_name']."</td>
        <td>".$row['address']."</td>
        <td>".$row['waste_details']."</td>
        <td>".$row['pickup_date']."</td>
        <td>".$row['pickup_time']."</td>
        <td>".$status_html."</td>
        </tr>";
    }
}
?>

</table>

</div>

</body>
</html>