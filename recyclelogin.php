<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("Database connection failed");
}

$error = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $email    = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $query = "SELECT * FROM recycle_team 
              WHERE username='$username' 
              AND email='$email' 
              AND password='$password'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['recycle_id'] = $row['id'];
        $_SESSION['recycle_username'] = $row['username'];

        header("Location: recycledashboard.php");
        exit();
    } else {
        $error = "❌ Invalid Username, Email, or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Recycle Team Login</title>
<style>
body{
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#a8edea,#fed6e3);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.login-box{
    background:white;
    padding:40px;
    width:360px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
    text-align:center;
}
h2{
    color:#2e8b57;
    margin-bottom:20px;
}
input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:15px;
}
button{
    width:100%;
    padding:12px;
    background:#2e8b57;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}
button:hover{
    background:#246b45;
}
.error{
    color:red;
    font-weight:bold;
    margin-bottom:10px;
}
</style>
</head>

<body>
<div class="login-box">
    <h2>♻️ Recycle Team Login</h2>

    <?php if($error!=""){ echo "<div class='error'>$error</div>"; } ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>

