<?php
// Database connection
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed: ".mysqli_connect_error());
}

// Fetch all works that have a volunteer assigned
$works = mysqli_query($conn,"SELECT wr.*, v.full_name AS volunteer_name 
                            FROM waste_requests wr 
                            LEFT JOIN volunteers v ON wr.assigned_volunteer = v.id
                            WHERE assigned_volunteer IS NOT NULL
                            ORDER BY wr.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Assigned Works</title>
<style>
body{font-family:Arial; background:#d9fdd3; padding:20px;}
h1{text-align:center;color:#2e8b57;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd;}
th{background:#2e8b57;color:white;}
.back-btn{padding:8px 14px;margin-bottom:15px;background:#555;color:white;border:none;border-radius:5px;cursor:pointer;}
.back-btn:hover{background:#333;}
</style>
</head>
<body>

<button class="back-btn" onclick="location.href='volunteerdashboard.php'">⬅ Back</button>
<h1>Assigned Works</h1>

<table>
<tr>
    <th>Request ID</th>
    <th>User</th>
    <th>Person Name</th>
    <th>Address</th>
    <th>Waste Details</th>
    <th>Pickup Date</th>
    <th>Pickup Time</th>
    <th>Assigned Volunteer</th>
    <th>Status</th>
</tr>

<?php
if(mysqli_num_rows($works) == 0){
    echo "<tr><td colspan='9'>No works assigned yet.</td></tr>";
}

while($row = mysqli_fetch_assoc($works)){
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['person_name']}</td>
        <td>{$row['address']}</td>
        <td>{$row['waste_details']}</td>
        <td>{$row['pickup_date']}</td>
        <td>{$row['pickup_time']}</td>
        <td>{$row['volunteer_name']}</td>
        <td>{$row['status']}</td>
    </tr>";
}
?>

</table>
</body>
</html>
