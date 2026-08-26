<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn) die("DB Connection Failed");

// Handle status update by admin
$msg = "";
if(isset($_POST['update_status'])){
    $rid = intval($_POST['request_id']);
    $status = $_POST['status'];

    // Only allow change if not Completed
    $check = mysqli_query($conn,"SELECT status FROM waste_requests WHERE id=$rid");
    $row = mysqli_fetch_assoc($check);
    if($row['status'] == "Collected"){
        $msg = "❌ Cannot change status of a collected request.";
    } else {
        mysqli_query($conn,"UPDATE waste_requests SET status='$status' WHERE id=$rid");
        $msg = "✅ Status updated successfully!";
    }
}

// Fetch all requests
$requests = mysqli_query($conn,"SELECT * FROM waste_requests ORDER BY id DESC");

// Fetch volunteers
$volunteers = [];
$vol_res = mysqli_query($conn,"SELECT * FROM volunteers ORDER BY full_name ASC");
while($v = mysqli_fetch_assoc($vol_res)){
    $volunteers[] = $v;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Waste Requests</title>
<style>
body{font-family:Arial;background:#f0f0f0;padding:20px;}
h2{text-align:center;color:#2e8b57;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;}
th,td{padding:10px;border-bottom:1px solid #ccc;text-align:center;}
th{background:#2e8b57;color:white;}
tr:nth-child(even){background:#f9f9f9;}
select,button{padding:6px 10px;border-radius:5px;border:1px solid #ccc;}
button{background:#2e8b57;color:white;border:none;cursor:pointer;}
button:hover{background:#246b45;}
p.msg{font-weight:bold;text-align:center;margin-bottom:15px;color:green;}
.status{font-weight:bold;}
.status.pending{color:red;}
.status.ongoing{color:orange;}
.status.completed{color:green;}
.back-btn{background:#555;color:white;padding:8px 16px;border:none;border-radius:6px;margin-bottom:15px;cursor:pointer;}
.back-btn:hover{background:#333;}
</style>
</head>
<body>

<button class="back-btn" onclick="window.location.href='admindashboard.php'">⬅ Back</button>
<h2>Admin: Waste Requests</h2>

<?php if($msg!="") echo "<p class='msg'>$msg</p>"; ?>

<table>
<tr>
<th>ID</th>
<th>User</th>
<th>Person</th>
<th>Address</th>
<th>Waste</th>
<th>Date</th>
<th>Time</th>
<th>Volunteer</th>
<th>Status</th>
<th>Update Status</th>
</tr>

<?php while($r = mysqli_fetch_assoc($requests)):
$vol_name = "-";
if(!empty($r['assigned_volunteer'])){
    foreach($volunteers as $v){
        if($v['id']==$r['assigned_volunteer']){
            $vol_name = $v['full_name']; break;
        }
    }
}
$status_class = strtolower($r['status']);
?>
<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['username']; ?></td>
<td><?php echo $r['person_name']; ?></td>
<td><?php echo $r['address']; ?></td>
<td><?php echo $r['waste_details']; ?></td>
<td><?php echo $r['pickup_date']; ?></td>
<td><?php echo $r['pickup_time']; ?></td>
<td><?php echo $vol_name; ?></td>
<td><span class="status <?php echo $status_class;?>"><?php echo $r['status'];?></span></td>
<td>
<?php if($r['status'] != "Collected"): ?>
<form method="post">
<input type="hidden" name="request_id" value="<?php echo $r['id'];?>">
<select name="status" required>
<option value="Pending" <?php if($r['status']=="Pending") echo "selected";?>>Pending</option>
<option value="Ongoing" <?php if($r['status']=="Ongoing") echo "selected";?>>Ongoing</option>
<option value="Collected"<?php if($r['status']=="collected")echo"selected";?>>collected</option>
</select>
<button type="submit" name="update_status">Update</button>
</form>
<?php else: ?>
Collected ✅
<?php endif;?>
</td>
</tr>
<?php endwhile;?>
</table>

</body>
</html>
