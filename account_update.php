<?php
    session_save_path("./session_path");
    if(!isset($_SESSION))
    session_start();

    $email = $_SESSION['email'];
   
    include('connect.php');
    $mysqli->select_db("jiangzh-db");
    
    // use SQl to update the new basic information for this account.
    $sql = "UPDATE Account SET firstname = ?, lastname = ?, major = ?, classstanding = ?
    WHERE email = '$email' ";
    
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("ssss", $firstname, $lastname, $major, $classstanding); 
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $major = $_POST['major']; 
        $classstanding = $_POST['cs'];                   
    }
    $stmt->execute();
    $stmt->close();   
    $mysqli->close();

    $_SESSION["user"] = "$firstname $lastname";
    header("Location: account.php?");
?>