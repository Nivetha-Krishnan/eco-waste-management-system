<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "myproject");
if (!$conn)
{
    die("DB connection failed");
}

$error = "";

if (isset($_POST['login'])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM mainlogin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) 
    {
        $_SESSION['main_user'] = $username;
        header("Location: home.php"); // ONLY redirect
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
<title>Main Login</title>
<style>
body
{
    margin:0;
    font-family: Arial;
    height:100vh;
    background:#d9fdd3;
    display:flex;
    justify-content:center;
    align-items:center;
}
form
{
    text-align:center;
}
input
{
    width:250px;
    padding:12px;
    font-size:16px;
    margin-bottom:15px;
}
button
{
    width:270px;
    padding:12px;
    font-size:16px;
    background:green;
    color:white;
    border:none;
    cursor:pointer;
}
</style>
</head>
<body>
<form method="post">
    <h2>Main Login</h2>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button name="login">Login</button>
    <p style="color:red;"><?php echo $error; ?></p>
</form>
</body>
</html>


