<!DOCTYPE html>
<?php
     session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

    // if user did not log in, then cannot directly enter this website.
    if(!isset($_SESSION['email'])){
        $url = "login.php";  
        echo "<script language='javascript' type='text/javascript'>";  
        echo "window.location.href='$url'";  
        echo "</script>"; 
        exit;
    }
?> 
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <meta charset="utf-8" />
        <title>account</title>
        <link href="css/account_style.css" rel="stylesheet" type="text/css" />
        <link href="css/header_style.css" rel=stylesheet type=text/css />
        <link href="css/global_style.css" rel="stylesheet" type="text/css" />
        <link href="css/account.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
        <script type="text/javascript"></script>  
    </head>

<body style="background-image:url(img/bg.jpg)">

<!-- header -->
<div id="head_area" style="background-image:url(img/header.jpg)">
    <div id="logo"><a href="index.php"><img src="img/logo.png"></a></div>
    <div id="account" style="display: inline-block">
        <div id="user"><span class="name"><?php echo $_SESSION["user"]?></span></div>
        <a id='act' href="question.php"><img src="img/q_a.png"></a>      
        <form action="logout.php"><input type="submit" value="Log out" class="btn"></form>    
    </div>
</div>

  <div id="w">
    <div id="content" class="clearfix">
      <h1>User Profile</h1>
        <!-- Show basic information of account -->
        <div id="display_area">
        <?php
          $email = $_SESSION['email'];
          include("connect.php");
          $mysqli->select_db("jiangzh-db");
          // use SQl to select basic information of this account      
          $sql = "SELECT firstname, lastname, major, classstanding FROM Account
          WHERE email = '$email' ";
          if($stmt = $mysqli->prepare($sql)){
            $stmt->execute();
            $stmt->bind_result($firstname, $lastname, $major, $cs);
              while($stmt->fetch()){
                echo"<p class='setting'>Email: " . $email . "</p>\n"; 
                echo"<p class='setting'>First Name: " . $firstname . "</p>\n"; 
                echo"<p class='setting'>Last Name: " . $lastname . "</p>\n";
                echo"<p class='setting'>Major: " . $major . "</p>\n"; 
                echo"<p class='setting'>Class Standing: " . $cs . "</p>\n"; 
              }
          }
          $stmt->close();   
          $mysqli->close();
        ?>
        </div>      
        <!-- The form used to update basic information of this account -->
        <div id="edit_area" style="display: none;"> 
          <p>Edit your user settings:</p>
          <form id="comment_form" action="account_update.php?" method="POST">
            <div class="setting">First Name: <input type="text" id="tc_input" name="firstname" class="focus"></div>
          
            <div class="setting">Last Name: <input type="text" id="tc_input" name="lastname" class="focus"></div>
            
            <div class="setting">Major: 
              <select name="major">
                <option value="CS">CS</option>
                <option value="ECE">ECE</option>
                <option value="ME">ME</option>
                <option value="CHE">CHE</option>
              </select>
            </div>
        
            <div class="setting">Class Standing:
              <select name="cs">
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
              </select>
            </div>  
            <div id="cmt"><input type="submit" id="msgbtn" class="btn" value="Submit"></div>  
          </form>
        </div>  
          
        <div id="change_area">
          <input id="change" type="button" onclick="edit_open()" class="btn" value="Eidt">
        </div>
      
      </div>
  </div>

<!-- Change these two area display and edit-->
<script type="text/javascript">
  function edit_open(){
      document.getElementById('edit_area').style.display = "block";
      document.getElementById('display_area').style.display = "none";
      document.getElementById('change_area').style.display = "none";
  }    
</script>

</body>
</html>
