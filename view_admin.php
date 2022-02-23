<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hồ sơ!</title>
</head>

<body id="view_admin">
	<?php # Script 10.5 - #5
	// Trang xem thông tin hồ sơ Admin

	$page_title = 'Xem người dùng hiện tại';
	include('session.php');
	global $tenltk;
	if ($tenltk == 'User') {
		include('includes/header_us.php');
	} else if ($tenltk == 'Admin') {
		include('includes/header_ad.php');
	} else {
		include('includes/header.php');
	}
	echo '<h1 style="color: green">Thông tin quản trị viên</h1>';

	include('ketnoi.php');

	$tentk = $_SESSION['tentk'];

	// Xác định truy vấn:
	$q1 = "SELECT quyentk, tentk, hoten, diachi, sdt, avatar, gtinh, tenltk
	  FROM public.user, public.loaitk
	  WHERE tentk='$tentk' AND public.user.maltk = public.loaitk.maltk";
	$r1 = @pg_query($conn, $q1); // Chạy truy vấn.

	$row1 = pg_fetch_array($r1, NULL, PGSQL_ASSOC);

	// Tìm nạp và in các bản ghi ....
	if (pg_num_rows($r1) == 1) {
		echo
		'<style>
    table {
        font-size: 13pt;
    }
</style>
<form action="edit_user.php" method="post" style="width: 800px; margin: 0 auto">
	<table class="table table-borderless table-primary" align="center" style="width: 800px; margin-top: 20px;">
		<tr class="bg-primary">
			<th colspan="3" style="text-align: center; font-size: 25pt; color: white">
			<b>THÔNG TIN CHI TIẾT</b></th>
		</tr>
	    <tr>
	        <td>
	            <table style="margin: 10px" cellpadding="2" cellspacing="10">
	                <tr>
	                    <td rowspan="8"><img src="images/' . $row1['avatar'] . '" width="250" height="350" style="margin-right: 10px" /></td>
	                </tr>
	                <tr>
	                    <td><b>Tên tài khoản:</b></td>
	                    <td>' . $row1['tentk'] . '</td>
	                </tr>
	                <tr>
	                    <td><b>Họ và tên:</b> </td>
	                    <td>' . $row1['hoten'] . '</td>
	                </tr>
	                <tr>
	                    <td><b>Địa chỉ:</b> </td>
	                    <td>' . $row1['diachi'] . '</td>
	                </tr>

	                <tr>
	                    <td><b>Số điện thoại:</b></td>
	                    <td>' . $row1['sdt'] . '</td>
	                </tr>

					<tr>
	                    <td><b>Quyền:</b></td>
	                    <td>' . $row1['tenltk'] . '</td>
	                </tr>

	                <tr>
	                    <td><b>Giới tính:</b></td>
	                    <td>' . $row1['gtinh'] . '</td>
	                </tr>
	            </table>
	            <div style="margin-left: 10px; font-size: 13pt; margin-bottom: 5px">
	                <a href="edit_user.php?id=' . $row1['tentk'] . '">Chỉnh sửa</a> |
	                <a href="xoa_user.php?id=' . $row1['tentk'] . '">Xóa người dùng</a>
	            </div>
	        </td> 
	    </tr>
	</table>
</form>';

		pg_free_result($r1);
		// pg_close($conn);
	}
	include('includes/footer.html'); ?>
	<!-- btn scroll top -->
	<div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
	<!-- end btn scroll top -->
	<script src="scripts/scrolltop2.js"></script>
</body>

</html>