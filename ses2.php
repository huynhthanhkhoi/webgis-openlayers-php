<?php
   include('ketnoi.php');
   session_start();
   $tenltk = '';
   
   if(!isset($_SESSION['tentk'])){
      
   }
   else 
   {
	   $user_check=$_SESSION['tentk'];
	   
	   $ses_sql=pg_query($conn,"SELECT tentk, hoten, avatar, tenltk FROM public.user, public.loaitk WHERE tentk='$user_check' AND public.user.maltk = public.loaitk.maltk");
	   
	   $row=pg_fetch_array($ses_sql, NULL, PGSQL_ASSOC);
	   
	   $tentk = $row['hoten'];
	   $avatar = $row['avatar'];	
      $tenltk = $row['tenltk'];
   }
?>