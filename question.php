<!DOCTYPE html>
<?php
session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

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
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <title>main</title>
        <link href="css/question.css" rel="stylesheet" type="text/css" />
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
            <form action="logout.php"><input type="submit" value="Log out" class="btn"></form>    
        </div>
    </div>

<!-- body -->
    <div id= "answer_list" class="container">
        <!--********************* Question List ************-->
        <h1 align="center"> Question List </h1>
        <div id="question_title">
            <?php
                include("connect.php");
                $mysqli->select_db("jiangzh-db");
                // use SQL to select all questions from table, and it includes a number of answes for this question 
                $sql = "SELECT A.firstname, A.lastname, Q.id, Q.title, Q.postdate, COUNT(Asw.qid)
                        FROM Question AS Q 
                        LEFT JOIN Account AS A ON A.id = Q.aid
                        LEFT JOIN Answer AS Asw ON Asw.qid = Q.id
                        GROUP BY Q.id
                        ORDER BY Q.postdate DESC";
                    
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->execute();
                    $stmt->bind_result($fname, $lname, $id, $title, $postdate, $num);
                    while($stmt->fetch()){
                        echo
                        "<div class='cmt_title'>" .
                            "<div id='questiontitle'>" .
                                "<a class='cn' href='answer.php?page=" . $id . "'>" . 
                                $title .
                                "</a>" . 
                            "</div>" .
                            "<div>" .
                                "<div><span class='info'>User:</span>" . $fname . " " . $lname . "</div>" .
                                "<div id='answer' style='float:left'><span class='info'>Number of Answer:</span><div id='answer_num' style='float:right'>" . $num . "</div></div>" .
                                "<div id='time_div' style='float:right'>" . $postdate . "</div>" .
                            "</div>" .
                        "</div>";  
                    }
                }
                $stmt->close();   
                $mysqli->close();   
            ?>
        </div>

        <!--****************** Question Post ******************-->
        <h1 align="center">Post a New Question</h1>
        <div id="comment-area">
            <form id="comment_form" action="question_insert.php?" method="POST">
                <div id="title"> 
                    <input type="text" id="tc_input" placeholder="enter title of question" name="title" class="focus"> 
                </div>                                                                                                   
                <div id="comment">                                
                    <textarea id="msg" name="question" placeholder="Add comment here..."></textarea>                    
                </div>
                <div id="cmt">
                    <input type="submit" id="msgbtn" class="btn" value="Submit">
                    <div id="msgdiv"></div>
                </div> 
            </form>
        </div>      
    </div>  
</body>
</html>
