<?php
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

    $email = $_SESSION['email'];
   
    include('connect.php');
    $mysqli->select_db("jiangzh-db");
    // use SQL to insert a new question to table    
    $sql = "INSERT INTO Question (aid, title, content, postdate) VALUES (
        (SELECT id FROM Account WHERE email = '$email'), ?, ?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sss", $title, $content, $postdate);  
        $title = $_POST['title'];                
        $content = $_POST['question'];    
        $postdate = date("Y-m-d H:i:s"); 
    }
    $stmt->execute();
    $stmt->close();

    header("Location: question.php");
?>