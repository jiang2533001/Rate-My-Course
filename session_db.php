<?php
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();
    
    $email = $_POST['logemail'];
    // connect database
    include("connect.php"); 
    $mysqli->select_db("jiangzh-db");  

    // use SQL query to store firstname and lastname to session
    $sql = "SELECT firstname, lastname FROM Account WHERE email = '$email'";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->execute();
    	$stmt->bind_result($fn, $ln);	
    	if($stmt->fetch()){
            $name = "$fn $ln";
        }  
    }
    $stmt->close();   
    $mysqli->close();
        
    $_SESSION["email"] = $email;
    $_SESSION["user"] = $name;
    header("Location: index.php?page=cs161");
?>