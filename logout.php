<?php
	session_save_path("./session_path");
	if(!isset($_SESSION))
    session_start();
    session_destroy();
    header("Location: login.php");        
?>