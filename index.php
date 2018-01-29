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
    
    // store current page to seesion, and then it will used to select relative information from table
    if(!isset($_GET['page'])){
        $_GET['page'] = 'cs161';
    }
    $_GET['page'] = str_replace(' ','',$_GET['page']);
    $_GET['page'] = strtolower($_GET['page']);
    $_SESSION["course"]=$_GET['page'];
?>    

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <title>main</title>
        <link href="css/main_style.css" rel="stylesheet" type="text/css" />
        <link href="css/header_style.css" rel=stylesheet type=text/css />
        <link href="css/global_style.css" rel="stylesheet" type="text/css" />
    </head>

    <body style="background-image:url(img/bg.jpg)">

    <!-- header -->
    <div id="head_area" style="background-image:url(img/header.jpg)">
        <div id="logo"><a href="index.php"><img src="img/logo.png"></a></div>
        <div id="account" style="display: inline-block">
            <div id="act"><span class="name"><?php echo $_SESSION["user"]?></span></div>
            <a id='act' href="account.php"><img src="img/account.png"></a>        
            <a id='act' href="question.php"><img src="img/q_a.png"></a>
            <form action="logout.php"><input type="submit" value="Log out" class="btn"></form>    
        </div>
    </div>

    <!-- main part -->
    <div class="main-body">
        <!--****************** course list ******************--> 
        <div id="course-area">
            <ul>
            <!-- connect to database and then select all courses as list -->
            <?php
				include("connect.php");
				$mysqli->select_db("jiangzh-db");
                // use SQL query to select all attributes of all courses
				$sql = "SELECT `category`, `number` FROM Course ORDER BY category";
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->execute();
                    $stmt->bind_result($category, $number);
                    while($stmt->fetch()){
                    $course = "$category$number";
                    echo "<li><a class='cn' id='" . $course . "' href='index.php?page=" . $course . "'>" . strtoupper($course) . "</a></li>\n";    
                    }
                }
                $stmt->close();   
                $mysqli->close();
            ?>
            </ul>
        </div>           
               
        <!--****************** comment list ******************-->
        <div id="content-area">
            <div id="coursetitle">
                <!-- connect to database and then calculate the average for this course-->
                <?php
                    echo "<div>" . strtoupper($_SESSION["course"]) . "</div>";

                    $str = $_SESSION['course'];
                    $arra = preg_split("/([a-zA-Z]+)/", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
                    $category = $arra[0];
                    $number = $arra[1];

                    include("connect.php");
                    $mysqli->select_db("jiangzh-db");
                    // use SQL query to calculate average of this course
                    $sql = "SELECT AVG(ratelevel) 
                    FROM Comment AS Co 
                    INNER JOIN Course AS C ON C.id = Co.cid
                    WHERE C.category = '$category' AND C.number = '$number' AND ratelevel NOT IN (0)";
                    
                    if($stmt = $mysqli->prepare($sql)){
                        $stmt->execute();
                        $stmt->bind_result($average);
                        while($stmt->fetch()){
                            if ($average == NULL)
                                echo "<div>coefficient of difficulty: N\A</div>";
                            else
                                echo "<div>coefficient of difficulty:" . round($average ,2) . "</div>";
                        }
                    }
                    $stmt->close();   
                    $mysqli->close();
                ?>
            </div>
            <div id="listcomment">
                <ul>
                    <!-- connect to database and then select all comments for this course--> 
                    <?php
                        include("connect.php");
                        $mysqli->select_db("jiangzh-db");
                        
                        $str = $_SESSION['course'];
                        $arra = preg_split("/([a-zA-Z]+)/", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
                        $category = $arra[0];
                        $number = $arra[1];

                        $sql = "SELECT A.firstname, A.lastname, Co.content, Co.ratelevel, Co.instructor, Co.postdate
                        FROM Comment AS Co
                        INNER JOIN Account AS A ON A.id = Co.aid
                        INNER JOIN Course AS C ON C.id = Co.cid
                        WHERE C.category = '$category' AND C.number = '$number'
                        ORDER BY Co.postdate DESC";
                        
                        if($stmt = $mysqli->prepare($sql)){
                            $stmt->execute();
                            $stmt->bind_result($fname, $lname, $content, $ratelevel, $instructor, $postdate);
                            while($stmt->fetch()){
    							if($ratelevel == 0)
    								$rate = "None";
    							else if($ratelevel == 1)
    								$rate = "Very Esay";
    							else if($ratelevel == 2)
    								$rate = "Esay";
    							else if($ratelevel == 3)
    								$rate = "Normal";
    							else if($ratelevel == 4)
    								$rate = "Hard";	
    							else if($ratelevel == 5)
    								$rate = "Very Hard";
    							else
    								$rate = "Don't Take!";
                                 echo "<div id='msg-Holder'>" .
                                        "<div class='eml_div'>" .      
                                            $fname . " " . $lname .
                                        "</div>" .
                                        "<div class='tea_div'>" .
                                            "<span class='info'>My Professor(instructor): </span>" .
                                            $instructor .
                                        "</div>" .
                                        "<div class='rate_div'>" .
                                            "<span class='info'>Course difficulty: </span>" .
                                            $rate . 
                                            "</div>" .
                                        "<div class='cmt_div'>" .
                                            "<span class='info'>Shared: </span>" .
                                             $content . 
                                        "</div>" . 
                                        "<div class='time_div'>" . 
                                            $postdate .
                                        "</div>" .
                                    "</div>";
                            }
                        }
                        $stmt->close();   
                        $mysqli->close();
                    ?>
                </ul>
            </div> 
        </div>

        <!--****************** post comment ******************-->
        <div id="comment-area">
            <form id="comment_form" action="comment_insert.php?" method="POST">
        
                <div id="teacher"> 
                    <input type="text" id="tc_input" placeholder="Who is your professor/teacher?" name="teacher" class="focus"> 
                    <div id="teacherdiv"></div>
                </div>
                  
                <div id="rate-btn">
                    <input type="radio" name="rate" value=1 id="radio1">
                    <label for="radio1">Very Esay</label>
                    <input type="radio" name="rate" value=2 id="radio2">
                    <label for="radio2">Esay</label>
                    <input type="radio" name="rate" value=3 id="radio3">
                    <label for="radio3">Normal</label>
                    <input type="radio" name="rate" value=4 id="radio4">
                    <label for="radio4">Hard</label>
                    <input type="radio" name="rate" value=5 id="radio5">
                    <label for="radio5">Very Hard</label>
                    <input type="radio" name="rate" value=6 id="radio6">
                    <label for="radio6">Don't Take!</label>
                    <input type="radio" name="rate" value=0 id="radio7">
                    <label for="radio7">None</label>
                </div>
                                                                                                                     
                <div id="comment">                                
                    <textarea id="msg" name="message" placeholder="Add comment here..."></textarea>                    
                </div>

                <div id="cmt">
                    <input id="msgbtn" type="submit" class="btn" value="Submit">
                </div> 
            </form>
        </div>       
    </div> 
    <!-- footer --> 
    </body>
</html>
