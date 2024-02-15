<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Employee Attendance Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style2.css">
    
   
    </style>
</head>
<?php
session_start();
include('includes/connection.php');
if(isset($_REQUEST['login']))
{
    $username = mysqli_real_escape_string($connection,$_REQUEST['username']);
    $pwd = mysqli_real_escape_string($connection,$_REQUEST['pwd']);
    
    $fetch_query = mysqli_query($connection, "select * from tbl_employee where username ='$username' and password = '$pwd' and role=0");
    $res = mysqli_num_rows($fetch_query);
    if($res>0)
    {
        $data = mysqli_fetch_array($fetch_query);
        $name = $data['first_name'].' '.$data['last_name'];
        $role = $data['role'];
        $id = $data['id'];
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        $_SESSION['id'] = $id;
        header('location:profile.php');
    }
    else
    {
        $msg = "Incorrect login details.";
    }
}
?>


<body>

<header>
    <nav class="navbar" style="margin-left: -10px">
        <a href="#" class="logo">
            <img src="assets/img/tvlogo.png" alt="logo">
            <h2>TimeVista-Employee</h2>
        </a>
        <ul class="links" >
            <span id="closeBtn" class="close-btn material-symbols-rounded">close</span>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.html" >About us</a></li>
            <li><a href="contact.html">Contact us</a></li>
        </ul>
        <button id="loginBtn" class="login-btn" >LOG IN</button>
    </nav>
    
</header>

<div id="loginPopup" class="form-popup" >
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" class="form-signin">
                        <div class="account-logo">
                            <h3>TimeVista</h3>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" autofocus="" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" required>
                        </div>
                        <span style="color:red;"><?php if(!empty($msg)){ echo $msg; } ?></span>
                        <br>
                        <div class="form-group text-center">
                            <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                        </div>
                           <div class="form-group">
                         <a href='admin' style="display: block; text-align: center;">Login as Admin</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");

const showPopupBtn = document.querySelector(".login-btn");
const formPopup = document.querySelector(".form-popup");

const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");



showPopupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});

hidePopupBtn.addEventListener("click", () => showPopupBtn.click());



</script>

</body>



</html>