<?php
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed");
}

$msg="";

/* MARK AS RECEIVED */
if(isset($_POST['received'])){
    $id = intval($_POST['rid']);
    mysqli_query($conn,
        "UPDATE recycle_requests 
         SET status='Received'
         WHERE id=$id"
    );
    $msg="♻️ Waste marked as Received";
}

/* FETCH INCOMING */
$q = mysqli_query($conn,
    "SELECT * FROM recycle_requests
     ORDER BY sent_date DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Recycle Centre - Incoming Waste</title>

<style>
body{
    font-family:Arial;
    background:#f0fff0;
    padding:30px;
}
h1{
    text-align:center;
    color:#228b22;
}
table{
    width:100%;
    background:#fff;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
}
th,td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #ddd;
}
th{
    background:#228b22;
    color:white;
}
button{
    padding:8px 14px;
    background:#228b22;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
.lock{
    color:green;
    font-weight:bold;
}
.msg{
    text-align:center;
    font-weight:bold;
    margin-bottom:15px;
}
</style>

</head>
<body>
    <button class="back-btn" onclick="location.href='recycledashboard.php'">⬅ Back</button>

<h1>♻️ Recycle Centre – Received Waste</h1>

<?php if($msg!=""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<table>
<tr>
<th>ID</th>
<th>Waste Request ID</th>
<th>Volunteer ID</th>
<th>Waste Details</th>
<th>Sent Date</th>
<th>Status</th>
</tr>

<?php
if(mysqli_num_rows($q)==0){
echo "<tr><td colspan='6'>No Incoming Waste</td></tr>";
}

while($r=mysqli_fetch_assoc($q)){
$status = $r['status'] ?? "Incoming";
?>

<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['waste_request_id']; ?></td>
<td><?php echo $r['volunteer_id']; ?></td>
<td><?php echo $r['waste_details']; ?></td>
<td><?php echo $r['sent_date']; ?></td>

<td>
<?php if($status=="Incoming"){ ?>
<form method="post">
<input type="hidden" name="rid" value="<?php echo $r['id']; ?>">
<button name="received">Mark Received</button>
</form>
<?php } else { ?>
<span class="lock">✅ Received</span>
<?php } ?>
</td>
</tr>

<?php } ?>
</table>

</body>
</html>

