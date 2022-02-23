<?php
   	include('ketnoi.php');
   	session_start();
	$tenltk = '';
	$maid = '';
   
   	$user_check=$_SESSION['tentk'];
   
    $ses_sql=pg_query($conn,"SELECT id, tentk, hoten, avatar, tenltk FROM public.user, public.loaitk WHERE tentk='$user_check' AND public.user.maltk = public.loaitk.maltk");

	$row=pg_fetch_array($ses_sql, NULL, PGSQL_ASSOC);
	   
	$maid = $row['id'];
	$tentk = $row['hoten'];
	$avatar = $row['avatar'];
	$tenltk = $row['tenltk'];		

   	if(!isset($_SESSION['tentk'])){
     	header("location:login.php");
   	}
?>