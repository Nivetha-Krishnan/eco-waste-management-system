<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn) die("DB connection failed");
?>
<!DOCTYPE html>
<html>
<head>
<title>Volunteer List</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}
body{min-height:100vh;background:url('image3.jpg') no-repeat center/cover;color:white;}
.overlay{min-height:100vh;background:rgba(0,0,0,0.6);display:flex;}
.sidebar{width:260px;background:#1f3d2b;padding:20px;}
.sidebar h2{text-align:center;margin-bottom:30px;}
.sidebar a{display:block;padding:12px;margin-bottom:10px;
    background:#2e8b57;color:white;text-decoration:none;border-radius:6px;}
.sidebar a:hover{background:#246b45;}

.main{flex:1;padding:30px;}
h1{margin-bottom:20px;}
.back-btn{
    padding:10px 20px;
    margin-bottom:20px;
    background:#2e8b57;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
.back-btn:hover{background:#246b45;}

table{width:100%;background:white;color:black;border-collapse:collapse;
    border-radius:10px;overflow:hidden;}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd;}
th{background:#2e8b57;color:white;}
</style>
</head>
<body>



    <!-- Main content -->
    <div class="main">
        <button class="back-btn" onclick="window.location.href='admindashboard.php'">⬅ Back</button>
        <h1>Registered Volunteers</h1>

        <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Place</th>
            <th>Availability</th>
        </tr>

        <?php
        $res = mysqli_query($conn,"SELECT * FROM volunteers ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($res)){
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['age']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['email']}</td>
                <td>{$row['place']}</td>
                <td>{$row['availability']}</td>
            </tr>";
        }
        ?>
        </table>
    </div>
</div>

</body>
</html>
