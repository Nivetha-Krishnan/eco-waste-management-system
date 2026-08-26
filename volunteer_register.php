<?php
session_start();
$conn = mysqli_connect("localhost","root","","myproject");
if(!$conn){
    die("DB Connection Failed: ".mysqli_connect_error());
}

$success_msg = "";
if(isset($_POST['register'])) {

    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $age = intval($_POST['age']);
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $place = $_POST['place'];
    $availability = $_POST['availability'];

    $sql = "INSERT INTO volunteers 
            (full_name, gender, age, contact_number, email, place, availability)
            VALUES 
            ('$name','$gender',$age,'$contact','$email','$place','$availability')";

    if(mysqli_query($conn,$sql)){
        $success_msg = "Registration Successful! Admin will review your details.";
    } else {
        $success_msg = "Error: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Registration</title>
    <style>
        body{
            font-family:Arial;
            background:#d9fdd3;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        form{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 3px 6px rgba(0,0,0,0.3);
            width:400px;
        }
        input, select, button{
            width:100%;
            padding:10px;
            margin:8px 0;
            border-radius:6px;
            border:1px solid #ccc;
        }
        button{
            background:green;
            color:white;
            border:none;
            cursor:pointer;
        }
        button:hover{
            background:#246b45;
        }
        p.success{
            color:green;
            margin-top:10px;
        }

        /* Back button style */
        .back-btn{
            background:#555;
            margin-bottom:10px;
        }
        .back-btn:hover{
            background:#333;
        }
    </style>
</head>
<body>

<form method="post">

    <!-- Back Button -->
    <button type="button" class="back-btn"
        onclick="location.href='volunteerdashboard.php'">
        ⬅ Back
    </button>

    <h2>Volunteer Registration</h2>

    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <label>Gender</label>
    <select name="gender" required>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select>

    <label>Age</label>
    <input type="number" name="age" min="18" max="100" required>

    <label>Contact Number</label>
    <input type="text" name="contact" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Place</label>
    <input type="text" name="place" required>

    <label>Availability</label>
    <select name="availability" required>
        <option>Morning</option>
        <option>Afternoon</option>
        <option>Evening</option>
        <option>Full day</option>
    </select>

    <button type="submit" name="register">Register</button>

    <?php
    if($success_msg!=""){
        echo "<p class='success'>$success_msg</p>";
    }
    ?>

</form>

</body>
</html>

