<?php
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

    $str = $_SESSION['course'];
    $arr = preg_split("/([a-zA-Z]+)/", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 

    $email = $_SESSION['email'];
    $category = $arr[0];
    $number = $arr[1];
 
    // connect database
    include('connect.php');
    $mysqli->select_db("jiangzh-db");

    // use SQL query to insert a new comment to table
    $sql = "INSERT INTO Comment (aid, cid, content, ratelevel, instructor, postdate) VALUES (
        (SELECT id FROM Account WHERE email = '$email'), 
        (SELECT id FROM Course WHERE category = '$category' AND `number` = '$number'),
        ?,?,?,?)";
    
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("siss", $content, $rate, $instructor, $time);
        if($_POST['teacher']=='')
            $_POST['teacher'] = 'N/A';
        if($_POST['rate']=='')
            $_POST['rate'] = 0;  
        
        $rate = $_POST['rate'];                
        $content = $_POST['message'];    
        $instructor = $_POST['teacher'];
        $time = date("Y-m-d H:i:s"); 
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    header("Location: index.php?page=" . $_SESSION['course']);
?>
