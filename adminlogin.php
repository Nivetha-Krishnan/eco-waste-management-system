<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "myproject");
if(!$conn){
    die("DB connection failed");
}

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM adminlogin WHERE admin_username='$username' AND admin_password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result)==1){
        $_SESSION['admin']=$username;   // admin session
        header("Location: admindashboard.php"); // admin dashboard
        exit();
    } else {
        $error="Invalid Admin Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{
    font-family:Arial;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    background:#d9fdd3;
}
form{text-align:center;}
input{
    width:250px;
    padding:12px;
    margin-bottom:15px;
}
button{
    width:270px;
    padding:12px;
    background:green;
    color:white;
    border:none;
    cursor:pointer;
}
</style>
</head>

<body>
<form method="post">
<h2>Admin Login</h2>

<input type="text" name="username" placeholder="Admin Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>

<button name="login">Login</button>

<p style="color:red;"><?php echo $error; ?></p>
</form>
</body>
</html>

