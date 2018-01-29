<?php
    // check session 
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();
    
    // connect database
    include('connect.php');
    $mysqli->select_db("jiangzh-db");
    
    // use SQL query to create a new account
    $sql = "INSERT INTO Account (email, password, firstname, lastname) VALUES (?,?,?,?)";
    if($stmt = $mysqli->prepare($sql)){
        // insert value to database
        $stmt->bind_param("ssss", $email, $password, $firstname, $lastname);             
        $email = $_POST['regemail'];    
        $password = $_POST['regpwd1'];
        $firstname = $_POST['regfname'];
        $lastname = $_POST['reglname'];
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
        
    $_SESSION["user"]="$firstname $lastname";
    $_SESSION["email"]=$email;

    // go back index.php
    header("Location: index.php?page=cs161");
?>
