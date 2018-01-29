<?php
	// connect database
    include("connect.php"); 
	$mysqli->select_db("jiangzh-db");
	$email = $_GET['email'];
	
    // use SQL query to checkt whether email address exists
    $sql = "SELECT email FROM Account WHERE email = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $email);
        $stmt->execute();
    	$stmt->bind_result($e);	
    	if($stmt->fetch()){
            echo 0;
		}else{
        	echo 1;
        }
    }    
    $stmt->close();   
    $mysqli->close();
?> 
