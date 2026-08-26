<?php
session_start();
if(!isset($_SESSION['user'])) { 
    header("Location: userlogin.php"); 
    exit(); 
}

$username = $_SESSION['user'];
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn) die("DB connection failed");

// Handle form submission
$success_msg = "";
if(isset($_POST['submit_request'])){
    $person = $_POST['requestedName'];
    $address = $_POST['door'].", ".$_POST['street'].", ".$_POST['place'].", ".$_POST['district'].", ".$_POST['state'];
    $waste_details = [];
    for($i=0;$i<count($_POST['waste_type']);$i++){
        $waste_details[] = $_POST['waste_type'][$i]." - ".$_POST['quantity'][$i]." ".$_POST['unit'][$i];
    }
    $waste_text = implode(", ", $waste_details);
    $date = $_POST['date'];
    $time = $_POST['time'].' '.$_POST['ampm'];

    $sql = "INSERT INTO waste_requests (username, person_name, address, waste_details, pickup_date, pickup_time, status, is_seen)
            VALUES ('$username', '$person', '$address', '$waste_text', '$date', '$time', 'Pending', 0)";

    if(mysqli_query($conn,$sql)) $success_msg = "Request Submitted Successfully!";
    else $success_msg = "Error: ".mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Waste Request</title>
<style>
/* Keep previous form CSS intact */
*{box-sizing:border-box;}
body{margin:0;font-family:Arial,sans-serif;background:url('image2.jpg') no-repeat center center fixed;background-size:cover;min-height:100vh;}
.main-content{width:92%;max-width:900px;margin:120px auto 40px;padding:20px;background:rgba(255,255,255,0.95);border-radius:12px;}
.card{background:white;padding:20px;border-radius:10px;box-shadow:0 3px 6px rgba(0,0,0,0.3);margin-bottom:25px;}
label{display:block;margin-top:10px;}
input,select,textarea,button{width:100%;padding:8px;margin-top:5px;border-radius:6px;border:1px solid #ccc;}
.submit-btn{background:#2e8b57;color:white;border:none;margin-top:15px;cursor:pointer;}
.submit-btn:hover{background:#246b45;}
.waste-row{display:flex;gap:5px;margin-bottom:5px;}
.waste-row select,.waste-row input{flex:1;}
.selected-wastes{background:#f0f0f0;padding:5px;border-radius:5px;margin-bottom:10px;}
.time-container{display:flex;gap:5px;}
.time-container select{width:70px;}
</style>
</head>
<body>

<div class="main-content">
 <button class="back-btn" onclick="location.href='userdashboard.php'">⬅ Back</button>   
<h2>Waste Collection Request</h2>
<div class="card">
<h3>Create Request</h3>
<?php if($success_msg!="") echo "<p style='color:green;'>$success_msg</p>"; ?>
<form method="post">
<label>Person Name</label>
<input type="text" name="requestedName" required>
<h4>Address</h4>
<input type="text" name="door" placeholder="Door No" required>
<input type="text" name="street" placeholder="Street" required>
<input type="text" name="place" placeholder="Place" required>
<input type="text" name="district" placeholder="District" required>
<input type="text" name="state" placeholder="State" required>
<label>Selected Wastes:</label>
<div id="selected-wastes" class="selected-wastes"></div>
<div id="waste-container"></div>
<button type="button" onclick="addWasteRow()">Add Waste Row</button>
<label>Date</label>
<input type="date" name="date" required>
<label>Time</label>
<div class="time-container">
<input type="time" name="time" required>
<select name="ampm">
<option>AM</option>
<option>PM</option>
</select>
</div>
<button type="submit" name="submit_request" class="submit-btn">Submit Request</button>
</form>
</div>
</div>

<script>
function addWasteRow(){
    const container=document.getElementById('waste-container');
    const div=document.createElement('div');
    div.className='waste-row';
    div.innerHTML=`<select name="waste_type[]" onchange="updateSelected()">
<option>Plastic</option><option>Paper</option><option>Glass</option><option>Metal</option>
<option>Kitchen</option><option>E-Waste</option><option>Fabric</option><option>Wood</option><option>Garden</option><option>Battery</option><option>Other</option>
</select>
<select name="unit[]" onchange="updateSelected()">
<option>kg</option><option>piece</option><option>other</option>
</select>
<input type="number" name="quantity[]" placeholder="Qty" min="0.1" step="0.1" required onchange="updateSelected()">
<button type="button" onclick="this.parentNode.remove();updateSelected()">Remove</button>`;
container.appendChild(div);
updateSelected();
}
function updateSelected(){
    const sel=document.getElementById("selected-wastes");
    sel.innerHTML="";
    document.querySelectorAll('.waste-row').forEach((r,i)=>{
        const type=r.querySelector('select[name="waste_type[]"]').value;
        const unit=r.querySelector('select[name="unit[]"]').value;
        const qty=r.querySelector('input[name="quantity[]"]').value;
        if(qty>0) sel.innerHTML+=`${i+1}. ${type} (${qty} ${unit})<br>`;
    });
}
addWasteRow();
</script>

</body>
</html>


