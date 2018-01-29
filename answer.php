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
        $url = "question.php";  
        echo "<script language='javascript' type='text/javascript'>";  
        echo "window.location.href='$url'";  
        echo "</script>"; 
        exit;
    }
    else
        $_SESSION["question"]=$_GET['page'];
?>    
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <title>Answer</title>
        <link href="css/answer.css" rel="stylesheet" type="text/css" />
        <link href="css/header_style.css" rel=stylesheet type=text/css />
        <link href="css/global_style.css" rel="stylesheet" type="text/css" />
    </head>

<body style="background-image:url(img/bg.jpg)">

<!-- header -->
    <div id="head_area" style="background-image:url(img/header.jpg)">
        <div id="logo"><a href="index.php"><img src="img/logo.png"></a></div>
        <div id="account" style="display: inline-block">
            <div id="act"><span class="name"><?php echo $_SESSION["user"]?></span></div>
            <a id="act" href="account.php"><img src="img/account.png"></a>
            <a id="act" href="question.php"><img src="img/q_a.png"></a>        
            <form action="logout.php"><input type="submit" value="Log out" class="btn"></form>    
        </div>
    </div>        
         
<!-- body -->
    <div id= "answer_list" class="container">
        <!--********************* Question *********************-->
        <h1 align="center">Question</h1>
        <div id="question_title">
        <?php
            $question = $_SESSION['question'];
                
            include("connect.php");
            $mysqli->select_db("jiangzh-db");
            // use SQL to select a question from table
            $sql = "SELECT A.firstname, A.lastname, Q.title, Q.content, Q.postdate
            FROM Question AS Q 
            INNER JOIN Account AS A ON A.id = Q.aid
            WHERE Q.id = '$question'";
                    
            if($stmt = $mysqli->prepare($sql)){
                $stmt->execute();
                $stmt->bind_result($fname, $lname, $title, $content, $postdate);
                while($stmt->fetch()){
                    echo
                        "<div>" .
                            "<div class='cmt_title'>" . 
                                "<div id='questiontitle'>" . $title . "</div>" .
                                "<div>". $content . "</div>" .
                            "</div>" .
                            "<div class='time_div'>" . $postdate . "</div>" .
                            "<div>" .
                                "<span class='info'>Name:</span>" . $fname . " " . $lname .
                            "</div>" . "
                        </div>"; 
                    }
                }
                $stmt->close();   
                $mysqli->close();   
            ?>
        </div>
        <!--******************* Answer List *********************-->
        <div id="Answer list">
            <div id="answer_title">Answer List</div>
            <?php
                $question = $_SESSION['question'];
                    
                include("connect.php");
                $mysqli->select_db("jiangzh-db");
                // use SQL to select all answers for this question from table
                $sql = "SELECT Ac.firstname, Ac.lastname, A.content, A.postdate
                FROM Answer AS A 
                INNER JOIN Account AS Ac ON Ac.id = A.aid
                INNER JOIN Question AS Q ON Q.id = A.qid
                WHERE A.qid = '$question'
                ORDER BY A.postdate DESC";
                        
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->execute();
                    $stmt->bind_result($fname, $lname, $content, $postdate);
                    while($stmt->fetch()){
                        echo
                            "<div id='listquestion answer'>" .
                                "<div id='answer-Holder'>" .
                                    "<div class='eml_div'>". $fname . " " . $lname . "</div>" .
                                    "<div class='cmt_div'><span class='info'>Answer: </span>" . $content . "</div>" .
                                    "<div class='time_div'>" . $postdate . "</div>" .
                                "</div>" .
                            "</div>";
                        }
                    }
                    $stmt->close();   
                    $mysqli->close();   
                ?>        
        </div>

        <!--****************** Post Answer *********************-->
        <h1 align="center">Post Answer</h1>  
        <div id="comment_area" class="center">
            <form id="comment_form" action="answer_insert.php?" method="POST">                                                                                                  
                <div id="comment">                                
                    <textarea id="msg" name="answer" placeholder="Add your answer here..."></textarea>                    
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