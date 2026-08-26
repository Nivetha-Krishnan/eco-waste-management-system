<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn) die("DB Connection Failed");

// Assign volunteer
$success_msg = "";
if(isset($_POST['assign'])){
    $request_id = intval($_POST['request_id']);
    $volunteer_id = intval($_POST['volunteer_id']);

    // Check if volunteer is already assigned
    $check = mysqli_query($conn,"SELECT assigned_volunteer FROM waste_requests WHERE id=$request_id");
    $row = mysqli_fetch_assoc($check);

    if(empty($row['assigned_volunteer'])){
        mysqli_query($conn,"UPDATE waste_requests SET assigned_volunteer=$volunteer_id WHERE id=$request_id");
        $success_msg = "✅ Volunteer Assigned Successfully!";
    } else {
        $success_msg = "⚠ Volunteer already assigned!";
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
<title>Admin Volunteer Assign & Updates</title>
<style>
body{font-family:Arial;background:#f0f0f0;padding:20px;}
table{width:100%;border-collapse:collapse;margin-bottom:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:center;}
th{background:#2e8b57;color:white;}
select,button{padding:4px 8px;border-radius:5px;border:1px solid #ccc;}
button{background:#2e8b57;color:white;border:none;cursor:pointer;}
button:hover{background:#246b45;}
p.success{color:green;margin-bottom:15px;}
p.error{color:red;margin-bottom:15px;}
.locked{color:green;font-weight:bold;}
form{margin:0;}
</style>
</head>
<body>
<button onclick="window.location.href='admindashboard.php'">⬅ Back</button>
<h2>Volunteer Assignments & Updates</h2>

<?php 
if($success_msg!=""){
    if(strpos($success_msg,'✅')!==false){
        echo "<p class='success'>$success_msg</p>";
    } else {
        echo "<p class='error'>$success_msg</p>";
    }
}
?>

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
<th>Volunteer Update</th>
</tr>

<?php while($req = mysqli_fetch_assoc($requests)):
$vol_name = "-";
if(!empty($req['assigned_volunteer'])){
    foreach($volunteers as $v){ 
        if($v['id']==$req['assigned_volunteer']){
            $vol_name=$v['full_name'];
            break;
        } 
    }
}
?>
<tr>
<td><?php echo $req['id']; ?></td>
<td><?php echo $req['username']; ?></td>
<td><?php echo $req['person_name']; ?></td>
<td><?php echo $req['address']; ?></td>
<td><?php echo $req['waste_details']; ?></td>
<td><?php echo $req['pickup_date']; ?></td>
<td><?php echo $req['pickup_time']; ?></td>
<td>
<?php if(empty($req['assigned_volunteer'])): ?>
<form method="post">
<input type="hidden" name="request_id" value="<?php echo $req['id']; ?>">
<select name="volunteer_id" required>
<option value="">Select Volunteer</option>
<?php foreach($volunteers as $vol){ echo "<option value='{$vol['id']}'>{$vol['full_name']}</option>"; } ?>
</select>
<button type="submit" name="assign">Assign</button>
</form>
<?php else: ?>
<span class="locked"><?php echo $vol_name; ?></span>
<?php endif; ?>
</td>
<td><?php echo !empty($req['volunteer_update'])?$req['volunteer_update']:"-"; ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>

