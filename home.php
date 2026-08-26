<!DOCTYPE html>
<html>
<head>
<title>Home</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
}

/* HOME PAGE */
.home{
    height:100vh;
    position:relative;
    color:white;
    overflow:hidden;
}

/* SLIDESHOW IMAGES */
.slideshow img{
    position:absolute;
    width:100%;
    height:100%;
    object-fit:cover;
    opacity:0;
    animation:slide 20s infinite;
}

.slideshow img:nth-child(1){animation-delay:0s;}
.slideshow img:nth-child(2){animation-delay:5s;}
.slideshow img:nth-child(3){animation-delay:10s;}
.slideshow img:nth-child(4){animation-delay:15s;}

@keyframes slide{
    0%{opacity:0;}
    10%{opacity:1;}
    25%{opacity:1;}
    35%{opacity:0;}
    100%{opacity:0;}
}

/* DARK OVERLAY */
.overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.4);
}

/* MODULE BUTTONS */
.modules{
    position:absolute;
    top:20px;
    right:20px;
    display:flex;
    gap:10px;
    z-index:2;
}

.modules a{
    text-decoration:none;
    background:green;
    color:white;
    padding:14px 22px;
    font-size:18px;
    font-weight:bold;
    border-radius:6px;
    transition:0.3s;
}

.modules a:hover{
    background:darkgreen;
}

/* WELCOME TEXT */
.welcome-text{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    font-size:36px;
    font-weight:bold;
    text-align:center;
    padding:30px;
    width:80%;
    z-index:2;
}

/* MOBILE */
@media(max-width:768px){
    .modules{
        flex-direction:column;
        top:10px;
        right:10px;
    }

    .modules a{
        font-size:16px;
        padding:10px;
    }

    .welcome-text{
        font-size:24px;
        padding:20px;
    }
}
</style>
</head>

<body>

<div class="home">

    <!-- Slideshow Images -->
    <div class="slideshow">
        <img src="image1.jpg">
        <img src="image2.jpg">
        <img src="image6.jpg">
        <img src="image7.jpg">
    </div>

    <div class="overlay"></div>

    <div class="modules">
        <a href="adminlogin.php">Admin</a>
        <a href="userlogin.php">User</a>
        <a href="volunteerdashboard.php">Volunteer</a>
        <a href="recycledashboard.php">Recycle Team</a>
        <a href="saleslogin.php">Product Sales</a>
        
    </div>

    <div class="welcome-text">
        <p>Welcome to Eco-Friendly Waste Collection and Recycling Product Sales Management System</p>
    </div>

</div>

</body>
</html>


