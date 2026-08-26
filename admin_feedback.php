<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed: ".mysqli_connect_error());
}

// Fetch all submitted feedback
$feedbacks = mysqli_query($conn,
    "SELECT uf.*, wr.username, wr.person_name
     FROM user_feedback uf
     LEFT JOIN waste_requests wr ON uf.request_id = wr.id
     ORDER BY uf.created_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - User Feedback</title>
<style>
body{
    font-family:Arial;
    background: linear-gradient(120deg,#f9f9f9,#d1fdd3);
    padding:20px;
}
h1{
    text-align:center;
    color:#2e8b57;
    margin-bottom:20px;
}
table{
    width:100%;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
    background:white;
}
th, td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}
th{
    background:#2e8b57;
    color:white;
}
.back-btn{
    background:#555;
    color:white;
    padding:8px 16px;
    border:none;
    border-radius:6px;
    margin-bottom:15px;
    cursor:pointer;
}
.back-btn:hover{background:#333;}
.star{
    color:orange;
    font-size:18px;
}
.user-info{
    font-weight:bold;
    color:#111;
}
</style>
</head>
<body>

<button class="back-btn" onclick="location.href='admindashboard.php'">⬅ Back</button>

<h1>All User Feedback</h1>

<table>
<tr>
    <th>Request ID</th>
    <th>User</th>
    <th>Person Name</th>
    <th>Q1: Service Rating</th>
    <th>Q2: Collected on time</th>
    <th>Q3: Volunteer Behavior</th>
    <th>Q4: Suggestions</th>
    <th>Q5: Staff Polite</th>
    <th>Q6: Recommend</th>
    <th>Q7: Issues Faced</th>
    <th>Submitted At</th>
</tr>

<?php
if(mysqli_num_rows($feedbacks)==0){
    echo "<tr><td colspan='11'>No feedback submitted yet.</td></tr>";
}

while($row = mysqli_fetch_assoc($feedbacks)){
    echo "<tr>
        <td>".$row['request_id']."</td>
        <td class='user-info'>".$row['username']."</td>
        <td>".$row['person_name']."</td>
        <td class='star'>".str_repeat("★",$row['q1']).str_repeat("☆",5-$row['q1'])."</td>
        <td>".$row['q2']."</td>
        <td>".$row['q3']."</td>
        <td>".$row['q4']."</td>
        <td>".$row['q5']."</td>
        <td>".$row['q6']."</td>
        <td>".$row['q7']."</td>
        <td>".$row['created_at']."</td>
    </tr>";
}
?>

</table>

</body>
</html>
