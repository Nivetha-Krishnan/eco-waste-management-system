<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed");
}

/* ✅ fetch completed based on volunteer update */
$completed = mysqli_query(
    $conn,
    "SELECT wr.*, v.full_name AS volunteer_name
     FROM waste_requests wr
     LEFT JOIN volunteers v ON wr.assigned_volunteer = v.id
     WHERE wr.volunteer_update='Completed'
     ORDER BY wr.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Completed Requests</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}
body{background:#eef6f0;padding:30px;}
h1{text-align:center;color:#2e8b57;margin-bottom:20px;}
table{width:100%;background:#fff;border-collapse:collapse;border-radius:10px;overflow:hidden;}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd;}
th{background:#2e8b57;color:white;}
.status{color:green;font-weight:bold;}
.back-btn{padding:10px 18px;background:#555;color:#fff;border:none;border-radius:6px;margin-bottom:15px;cursor:pointer;}
.back-btn:hover{background:#333;}
</style>
</head>

<body>

<button class="back-btn" onclick="window.location.href='admindashboard.php'">⬅ Back</button>

<h1>Completed Waste Collection Requests</h1>

<table>
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Person</th>
    <th>Address</th>
    <th>Waste</th>
    <th>Date</th>
    <th>Volunteer</th>
    <th>Status</th>
</tr>

<?php
if(mysqli_num_rows($completed)==0){
    echo "<tr><td colspan='8'>No completed requests yet</td></tr>";
}

while($row=mysqli_fetch_assoc($completed)){
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['person_name']}</td>
        <td>{$row['address']}</td>
        <td>{$row['waste_details']}</td>
        <td>{$row['pickup_date']}</td>
        <td>{$row['volunteer_name']}</td>
        <td class='status'>Completed</td>
    </tr>";
}
?>
</table>

</body>
</html>

