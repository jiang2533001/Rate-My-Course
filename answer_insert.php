<?php
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

    $email = $_SESSION['email'];
    $question = $_SESSION['question'];
    
    include('connect.php');
    $mysqli->select_db("jiangzh-db");
    // use SQl to insert a new answer for this question to table
    $sql = "INSERT INTO Answer (aid, qid, content, postdate) VALUES (
        (SELECT id FROM Account WHERE email = '$email'), 
        (SELECT id FROM Question WHERE id = '$question'),
        ?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("ss", $content, $postdate);                  
        $content = $_POST['answer'];    
        $postdate = date("Y-m-d H:m:s"); 
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    header("Location: answer.php?page=" . $_SESSION['question']);
?>