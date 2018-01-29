<?php
	$email = $_GET['logemail'];
    $password = $_GET['logpwd'];
	
    include("connect.php"); 
    $mysqli->select_db("jiangzh-db");
    
    // use SQL query to check whether email and password are valid
    $sql = "SELECT email, password FROM Account WHERE email = ?";
	if($stmt = $mysqli->prepare($sql)){
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    	mysqli_stmt_bind_result($stmt, $e, $p);	
    	if(mysqli_stmt_fetch($stmt)){
           if($p==$password)
                echo 1;
            else
                echo 0;
		}else{
        	echo 0;
        }
    } 
    $stmt->close();   
    $mysqli->close();
?>       
