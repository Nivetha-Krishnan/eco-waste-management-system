<?php
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed");
}

$msg="";
$volunteer=null;
$works=null;

/* FIND VOLUNTEER */
if(isset($_POST['find_work'])){
    $name  = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $v = mysqli_query($conn,
        "SELECT * FROM volunteers 
         WHERE full_name='$name' AND email='$email'"
    );

    if(mysqli_num_rows($v)==1){
        $volunteer = mysqli_fetch_assoc($v);
        $vid = $volunteer['id'];

        $works = mysqli_query($conn,
            "SELECT * FROM waste_requests
             WHERE assigned_volunteer=$vid
             ORDER BY id DESC"
        );
    }else{
        $msg="❌ Volunteer not found";
    }
}

/* UPDATE STATUS */
if(isset($_POST['update_status'])){
    $rid = intval($_POST['request_id']);
    $status = $_POST['status'];

    $c = mysqli_query($conn,
        "SELECT volunteer_update FROM waste_requests WHERE id=$rid"
    );
    $r = mysqli_fetch_assoc($c);

    if($r['volunteer_update']!="Completed"){
        mysqli_query($conn,
            "UPDATE waste_requests 
             SET volunteer_update='$status'
             WHERE id=$rid"
        );
        $msg="✅ Status Updated";
    }
}

/* SEND TO RECYCLE */
if(isset($_POST['send_to_recycle'])){
    $rid = intval($_POST['rid']);

    $q = mysqli_query($conn,"SELECT * FROM waste_requests WHERE id=$rid");
    $row = mysqli_fetch_assoc($q);

    mysqli_query($conn,"
        INSERT INTO recycle_requests
        (waste_request_id, volunteer_id, waste_details)
        VALUES(
            $rid,
            {$row['assigned_volunteer']},
            '{$row['waste_details']}'
        )
    ");

    mysqli_query($conn,"
        UPDATE waste_requests
        SET volunteer_update='Completed'
        WHERE id=$rid
    ");

    $msg="♻️ Sent to Recycle & Locked";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Volunteer Work Status</title>

<style>
body{font-family:Arial;background:#e6ffee;padding:25px}
h1{text-align:center;color:#2e8b57}
form,table{background:#fff;padding:20px;border-radius:10px;margin-bottom:20px}
input,select,button{padding:10px;margin:6px}
button{background:#2e8b57;color:white;border:none;border-radius:5px}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:center;border-bottom:1px solid #ccc}
th{background:#2e8b57;color:white}
.lock{color:green;font-weight:bold}
.msg{text-align:center;font-weight:bold;margin-bottom:15px}
.back{background:#555}
</style>

</head>
<body>

<button class="back" onclick="location.href='volunteerdashboard.php'">⬅ Back</button>

<h1>Volunteer Work Status</h1>

<?php if($msg!=""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<form method="post">
<h3>Volunteer Login</h3>
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<button name="find_work">View Work</button>
</form>

<?php if($volunteer && $works){ ?>

<h3>Welcome <?php echo $volunteer['full_name']; ?> 👋</h3>

<table>
<tr>
<th>ID</th>
<th>Address</th>
<th>Waste</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
if(mysqli_num_rows($works)==0){
echo "<tr><td colspan='6'>No Work</td></tr>";
}

while($w=mysqli_fetch_assoc($works)){
$st=$w['volunteer_update'] ?? "Pending";
?>

<tr>
<td><?php echo $w['id']; ?></td>
<td><?php echo $w['address']; ?></td>
<td><?php echo $w['waste_details']; ?></td>
<td><?php echo $w['pickup_date']; ?></td>
<td class="lock"><?php echo $st; ?></td>

<td>
<?php if($st!="Completed"){ ?>
<form method="post" onsubmit="return collectedCheck(this)">
<input type="hidden" name="request_id" value="<?php echo $w['id']; ?>">
<select name="status" class="status">
<option <?php if($st=="Pending")echo"selected"; ?>>Pending</option>
<option <?php if($st=="Ongoing")echo"selected"; ?>>Ongoing</option>
<option <?php if($st=="Collected")echo"selected"; ?>>Collected</option>
</select>
<button name="update_status">Update</button>
</form>
<?php } else { echo "🔒 Locked"; } ?>
</td>
</tr>

<?php } ?>
</table>
<?php } ?>

<!-- POPUP -->
<div id="popup" style="display:none;position:fixed;
top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,.6);
justify-content:center;align-items:center">

<div style="background:#fff;padding:25px;border-radius:10px;width:320px;text-align:center">
<h3>Send to Recycle?</h3>
<p id="popupText"></p>

<form method="post">
<input type="hidden" name="rid" id="rid">
<button name="send_to_recycle">Send to Recycle</button>
</form>

<button onclick="closePop()" style="margin-top:10px;background:#555">Cancel</button>
</div>
</div>

<script>
function collectedCheck(f){
let s=f.querySelector(".status").value;
if(s==="Collected"){
let row=f.closest("tr");
document.getElementById("popupText").innerText =
row.children[2].innerText;
document.getElementById("rid").value =
f.querySelector("input[name=request_id]").value;
document.getElementById("popup").style.display="flex";
return false;
}
return true;
}
function closePop(){
document.getElementById("popup").style.display="none";
}
</script>

</body>
</html>
