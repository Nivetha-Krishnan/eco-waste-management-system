<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: userlogin.php");
    exit();
}
$username = $_SESSION['user'];

// Database connection
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed: ".mysqli_connect_error());
}

$msg = "";

// Handle form submission
if(isset($_POST['submit_feedback'])){
    $request_id = intval($_POST['request_id']);
    $q1 = intval($_POST['q1']); // star rating
    $q2 = $_POST['q2']; // Yes/No
    $q3 = $_POST['q3']; // dropdown
    $q4 = mysqli_real_escape_string($conn,$_POST['q4']); // suggestions/comments
    $q5 = $_POST['q5']; // Yes/No
    $q6 = $_POST['q6']; // dropdown
    $q7 = mysqli_real_escape_string($conn,$_POST['q7']); // issues

    $insert = mysqli_query($conn,"INSERT INTO user_feedback 
        (request_id,q1,q2,q3,q4,q5,q6,q7, created_at) 
        VALUES ($request_id,'$q1','$q2','$q3','$q4','$q5','$q6','$q7',NOW())");

    if($insert){
        $msg = "✅ Thank you! Your feedback has been submitted.";
        mysqli_query($conn,"UPDATE waste_requests SET feedback_status='Submitted' WHERE id=$request_id");
    } else {
        $msg = "❌ Error submitting feedback: ".mysqli_error($conn);
    }
}

// Fetch completed requests for this user that have no feedback yet
$requests = mysqli_query($conn,"SELECT * FROM waste_requests 
    WHERE username='$username' AND status='Collected' AND (feedback_status='Pending' OR feedback_status IS NULL)
    ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Submit Feedback</title>
<style>
body{font-family:Arial; background: linear-gradient(135deg,#fceabb,#f8b500); padding:20px;}
h1{text-align:center; color:#2e8b57; margin-bottom:20px;}
form{background:white; padding:25px; border-radius:15px; max-width:800px; margin:auto; box-shadow:0 8px 20px rgba(0,0,0,0.2);}
label{font-weight:bold; color:#111; display:block; margin-top:15px; margin-bottom:5px;}
select, textarea{width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; margin-bottom:10px; font-size:16px;}
textarea{resize:vertical; height:80px;}
input[type=radio]{margin-right:6px;}
button{padding:10px 20px; background:#2e8b57; color:white; border:none; border-radius:8px; cursor:pointer; font-size:16px; margin-top:15px;}
button:hover{background:#246b45;}
.msg{text-align:center; font-weight:bold; margin-bottom:15px; color:green;}
.back-btn{background:#555; color:white; padding:8px 16px; border:none; border-radius:6px; margin-bottom:15px; cursor:pointer;}
.back-btn:hover{background:#333;}
.star span{font-size:28px; cursor:pointer; margin-right:5px; transition: transform 0.2s;}
.star span:hover{transform: scale(1.3); color:orange;}
.user-info{background:#ffefc2; padding:10px; border-radius:8px; margin-bottom:15px; font-weight:bold; color:#333; text-align:center;}
</style>
<script>
function setStar(value){
    const stars = document.querySelectorAll(".star span");
    stars.forEach((s,i)=> s.textContent = (i<value?"★":"☆"));
    document.getElementById("q1").value = value;
}
</script>
</head>
<body>

<button class="back-btn" onclick="location.href='userdashboard.php'">⬅ Back</button>

<h1>Submit Feedback</h1>

<?php if($msg!=""){ echo "<p class='msg'>$msg</p>"; } ?>

<?php if(mysqli_num_rows($requests)==0){ ?>
<p style="text-align:center; color:#333; font-weight:bold;">No completed requests available for feedback.</p>
<?php } else { 
    while($r = mysqli_fetch_assoc($requests)){ ?>
<form method="post">
    <div class="user-info">
        Request ID: <?php echo $r['id']; ?> | User: <?php echo $r['username']; ?> | Person Name: <?php echo $r['person_name']; ?>
    </div>
    <input type="hidden" name="request_id" value="<?php echo $r['id']; ?>">

    <!-- 1. Star rating -->
    <label>1️⃣ How satisfied are you with our service? ⭐</label>
    <input type="hidden" id="q1" name="q1" value="0">
    <div class="star">
        <?php for($i=1;$i<=5;$i++){ ?>
            <span onclick="setStar(<?php echo $i; ?>)">☆</span>
        <?php } ?>
    </div>

    <!-- 2. Yes/No -->
    <label>2️⃣ Was the waste collected on time? ✅ / ❌</label>
    <input type="radio" name="q2" value="Yes" required> Yes
    <input type="radio" name="q2" value="No" required> No

    <!-- 3. Dropdown -->
    <label>3️⃣ How would you rate the volunteer’s behavior? 😊</label>
    <select name="q3" required>
        <option value="">Select</option>
        <option value="Excellent">Excellent</option>
        <option value="Good">Good</option>
        <option value="Average">Average</option>
        <option value="Poor">Poor</option>
    </select>

    <!-- 4. Suggestions -->
    <label>4️⃣ Any suggestions or comments? 💬</label>
    <textarea name="q4" placeholder="Write your comments here..." required></textarea>

    <!-- 5. Yes/No -->
    <label>5️⃣ Was the pickup staff polite and helpful? 😊 / 😡</label>
    <input type="radio" name="q5" value="Yes" required> Yes
    <input type="radio" name="q5" value="No" required> No

    <!-- 6. Recommend -->
    <label>6️⃣ How likely are you to recommend our service to others? 🌟</label>
    <select name="q6" required>
        <option value="">Select</option>
        <option value="Very Likely">Very Likely</option>
        <option value="Likely">Likely</option>
        <option value="Neutral">Neutral</option>
        <option value="Unlikely">Unlikely</option>
        <option value="Very Unlikely">Very Unlikely</option>
    </select>

    <!-- 7. Issues -->
    <label>7️⃣ Any issues faced during the collection process? ⚠️</label>
    <textarea name="q7" placeholder="Describe any issues..." required></textarea>

    <button type="submit" name="submit_feedback">Submit Feedback</button>
</form>
<?php } } ?>

</body>
</html>

