<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="renderer" content="webkit" />
    <title>log in</title>
    <link href="css/login_style.css" rel="stylesheet" type="text/css" />
    <link href="css/global_style.css" rel="stylesheet" type="text/css" />
    <!-- connect javascript to check information -->
    <script type="text/javascript" src="check_login.js"></script>
</head>

<body style="background-image:url(img/bg.jpg);">
<div class="main-body">
    <!-- header --> 
    <div id="head_area" style="background-image:url(img/header.jpg)">
        <div id="logo"><img src="img/logo.png"></div>
        <form action="signup.php">
            <input type="submit" value="Sign up" class="btn">
        </form>
    </div>
    <!-- User needs to type information for log in -->
    <div id="container">
        <!-- Connect session_db.php and put information to session -->
        <form id="login_form"  method="POST" name="login_form" action="session_db.php"> 
            <h1>Log-in</h1>             
            <input type="email" id="logemail" autocomplete="on" name="logemail" placeholder="Email Address" class="input">
            <br><br>
            <input type="password" id="logpwd" autocomplete="off" placeholder="Password" class="input">
            <div id="show"></div>
            <br><br>
            <input id="logbtn" type="button" value="Login" onclick="login_in()" class="btn"> 
        </form>                                    
    </div>
</div>
</body>
</html>
