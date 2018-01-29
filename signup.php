<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <title>Sign up</title>
        <link href="css/login_style.css" rel="stylesheet" type="text/css" />
        <link href="css/global_style.css" rel="stylesheet" type="text/css" />
        <!-- connect javascript to check information -->
        <script type="text/javascript" src="check_signup.js"></script>
    </head>

<body style="background-image:url(img/bg.jpg);">
<div class="main-body">
    <!-- header -->
    <div id="head_area" style="background-image:url(img/header.jpg)">
        <div id="logo"><img src="img/logo.png"></div>
        <form action="login.php">
            <input type="submit" value="Log in" class="btn">
        </form>
    </div>

    <!-- User needs to type information for sign up -->
    <div id="container">
        <!-- Connect insert.php and insert these information to database -->
        <form method="POST" id="signup_form" action="account_insert.php">     
                <h1>Sign-up</h1>
                <input type="email" id="regemail" autocomplete="on" name="regemail" placeholder="example@email.com" class="input">
                <div id="emaildiv"></div>
                <br>    
                <input type="text" id="regfname" autocomplete="on" name="regfname" placeholder="First Name" class="input">
                <div id="namediv1"></div>
                <br>
                <input type="text" id="reglname" autocomplete="on" name="reglname" placeholder="Last Name" class="input">
                <div id="namediv2"></div>
                <br>                    
                <input type="password" id="regpwd1" autocomplete="off" name="regpwd1" placeholder="Password" class="input">
                <div id="pwddiv1"></div>
                <br> 
                <input type="password" id="regpwd2" autocomplete="off" name="regpwd2" placeholder="Re-enter Password" class="input">
                <div id="pwddiv2"></div>     
                <br><br>
                <input id="regbtn" type="button" onclick="set_up()" value="Sign up" class="btn">
                <div id="btndiv"></div>  
        </form>        
      </div>                        
    </div>
</body>
</html>
