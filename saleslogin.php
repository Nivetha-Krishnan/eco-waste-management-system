<?php
session_start();
$conn = mysqli_connect("localhost","root","","myproject");

if(!$conn){
    die("Database Connection Failed");
}

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM sales_team WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['sales_id'] = $row['id'];
        $_SESSION['sales_username'] = $row['username'];

        header("Location: salesdashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Sales Login</title>

<style>

body{
font-family:Arial;
background:linear-gradient(135deg,#74ebd5,#4facfe);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.login-box{
background:white;
padding:35px;
border-radius:10px;
width:320px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
text-align:center;
}

h2{
margin-bottom:20px;
color:#1b3a4b;
}

input{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ccc;
border-radius:6px;
}

button{
width:100%;
padding:10px;
background:#2c7da0;
color:white;
border:none;
border-radius:6px;
font-weight:bold;
cursor:pointer;
}

button:hover{
background:#1e6091;
}

.error{
color:red;
margin-bottom:10px;
}

</style>
</head>

<body>

<div class="login-box">

<h2>Sales Team Login</h2>

<?php if(isset($error)){ echo "<div class='error'>$error</div>"; } ?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

</div>

</body>
</html>
