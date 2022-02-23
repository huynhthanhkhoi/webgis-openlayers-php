<?php 
	session_start(); 
	if (isset($_SESSION['tentk'])){
	    unset($_SESSION['tentk']); // Xóa session login
	    header("location:index.php");
	}
?>