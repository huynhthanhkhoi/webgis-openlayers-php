<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hồ sơ người dùng!</title>
</head>

<body id="view_user">
	<?php # Script 10.5 - #5
	// Xem thông tin hồ sơ người dùng
	// Nếu là User chỉ xem được hồ sơ cá nhân
	// Nếu là Admin sẽ xem được thông tin của tất cả người dùng

	$page_title = 'Xem thông tin!';
	include('session.php');
	global $tenltk;
	if ($tenltk == 'User') {
		include('includes/header_us.php');
	} else if ($tenltk == 'Admin') {
		include('includes/header_ad.php');
	} else {
		include('includes/header.php');
	}
	echo '<h1 style="color: green">Người dùng đã đăng ký</h1>';

	include('ketnoi.php');

	$tentk = $_SESSION['tentk'];

	// Xác định truy vấn:
	$q1 = "SELECT quyentk, tentk, hoten, diachi, sdt, avatar, gtinh, tenltk
	  FROM public.user, public.loaitk
	  WHERE tentk='$tentk' AND public.user.maltk = public.loaitk.maltk";
	$r1 = @pg_query($conn, $q1); // Chạy truy vấn.

	$row1 = pg_fetch_array($r1, NULL, PGSQL_ASSOC);

	// Tìm nạp và in các bản ghi ....
	if ($row1['tenltk'] == 'User') { // Nếu là User
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
	                    <td>' . trim($row1['sdt']) . '</td>
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
	                <a href="xoa_user.php?id=' . $row1['tentk'] . '">Xóa tài khoản</a>
	            </div>
	        </td> 
	    </tr>
	</table>
</form>';

		pg_free_result($r1);
		// pg_close($conn);
	} else { // Ngược lại nếu là Admin
		echo '<button><a class="form-control" style="background: red; color: white;" href="dki_admin.php">Thêm Admin <img src="images/edit_add.png" width="24" height="24"/></a></button>';
		// Số lượng bản ghi sẽ hiển thị trên mỗi trang:
		$display = 10;

		// Xác định xem có bao nhiêu trang ...
		if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Đã được xác định.
			$pages = $_GET['p'];
		} else { // Cần xác định.
			// Đếm số lượng bản ghi:
			$q2 = "SELECT COUNT(tentk) FROM public.user";
			$r2 = @pg_query($conn, $q2);
			$row2 = @pg_fetch_array($r2, 0, PGSQL_NUM);
			$records = $row2[0];
			// Tính số trang ...
			if ($records > $display) { // Nhiều hơn 1 trang.
				$pages = ceil($records / $display);
			} else {
				$pages = 1;
			}
		} // End of p IF.

		// Xác định vị trí trong cơ sở dữ liệu để bắt đầu trả về kết quả ...
		if (isset($_GET['s']) && is_numeric($_GET['s'])) {
			$start = $_GET['s'];
		} else {
			$start = 0;
		}

		// Xác định sắp xếp ...
		// Mặc định là theo họ tên.
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'fn';

		// Xác định thứ tự sắp xếp:
		switch ($sort) {
			case 'ln':
				$order_by = 'tentk ASC';
				break;
			case 'fn':
				$order_by = 'hoten ASC';
				break;
			case 'ad':
				$order_by = 'diachi ASC';
				break;
			default:
				$order_by = 'hoten ASC';
				$sort = 'fn';
				break;
		}

		// Xác định truy vấn:
		$q3 = "SELECT quyentk, tentk, hoten, diachi, sdt, avatar, gtinh, tenltk
	FROM public.user, public.loaitk
	WHERE public.user.maltk = public.loaitk.maltk ORDER BY $order_by LIMIT $display OFFSET $start";
		$r3 = @pg_query($conn, $q3); // Chạy truy vấn.

		// Tiêu đề bảng:
		echo '<table class="table table-bordered" align="center" cellspacing="0" cellpadding="5" width="100%" style="margin-top: 20px">
	<tr class="bg-primary">
			<th colspan="9" style="text-align: center; font-size: 25pt; color: white">
			<b>THÔNG TIN CHI TIẾT THÀNH VIÊN</b></th>
	</tr>
	<tr>
		<td align="left" width="50"><b>STT</b></td>
		<td align="left"><b><a href="view_users3.php?sort=ln">User Name</a></b></td>
		<td align="left"><b><a href="view_users3.php?sort=fn">Họ và tên</a></b></td>
		<td align="left"><b><a href="view_users3.php?sort=ad">Địa chỉ</a></b></td>
		<td align="left"><b><a href="view_users3.php?">SDT</a></b></td>
		<td align="left"><b><a href="view_users3.php?">Giới tính</a></b></td>
		<td align="left"><b><a href="view_users3.php?">Quyền</a></b></td>
		<td align="left" width="110"><b><a href="view_users3.php?">Trạng thái</a></b></td>
		<td align="left" width="130"><b>Chức năng</b></td>
	</tr>
	';

		// Tìm nạp và in tất cả các bản ghi ....
		$bg = '#eeeeee';
		$stt = 0;
		while ($row2 = pg_fetch_array($r3, NULL, PGSQL_ASSOC)) {
			$bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
			echo '<tr bgcolor="' . $bg . '">
			<td style="text-align: center">';
			echo $stt = $stt + 1;
			echo '</td>
			<td align="left">' . $row2['tentk'] . '</td>
			<td align="left">' . $row2['hoten'] . '</td>
			<td align="left">' . $row2['diachi'] . '</td>
			<td align="left">' . trim($row2['sdt']) . '</td>
			<td align="left">' . $row2['gtinh'] . '</td>
			<td align="left">' . $row2['tenltk'] . '</td>
			<td style="text-align: center">';
			if ($row2['quyentk'] == 't') {
				echo '<abbr title="Đang kích hoạt"><img src="images/tick.png" width="22" height="24" /></abbr>';
			} else {
				echo '<abbr title="Vô hiệu hóa"><img src="images/disable_4.png" width="24" height="24" /></abbr>';
			};
			echo '</td>
			<td align="left">
				<a href="edit_user_ad.php?id=' . $row2['tentk'] . '" class="edit-btn">
					<abbr title="Chỉnh sửa"><img src="images/edit.png" width="22" height="24" style="margin-left: 5px; margin-right: 5px"/></abbr>
				</a>
				<a href="view_detail.php?id=' . $row2['tentk'] . '" class="edit-btn">
					<abbr title="Xem chi tiết"><img src="images/detail.png" width="22" height="22" style="margin-left: 5px; margin-right: 5px"/></abbr>
				</a>
				<a href="delete_user.php?id=' . $row2['tentk'] . '" class="edit-btn">
					<abbr title="Xóa người dùng"><img src="images/delete.png" width="22" height="22" style="margin-left: 5px; margin-right: 5px"/></abbr>
				</a>
			</td>
		</tr>';
		} // Kết thúc vòng lặp WHILE.
		echo '</table>';

		pg_free_result($r3);
		// pg_close($conn);

		// Tạo các liên kết đến các trang khác, nếu cần.
		if ($pages > 1) {

			echo '<div style="width: 100%; text-align: center;"><b>';
			$current_page = ($start / $display) + 1;

			// Nếu đó không phải là trang đầu tiên, hãy tạo nút Previous:
			if ($current_page != 1) {
				echo '<a class="angle-left" href="view_users3.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-left"></i></a> ';
			}

			// Tạo tất cả các trang được đánh số:
			for ($i = 1; $i <= $pages; $i++) {
				if ($i != $current_page) {
					echo '<a class="linkPaggingList" href="view_users3.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
				} else {
					echo '<a class="linkPaggingList active">'. $i .'</a>';
				}
			} // Kết thúc vòng lặp FOR.

			// Nếu đó không phải là trang cuối cùng, hãy tạo nút Next:
			if ($current_page != $pages) {
				echo '<a class="angle-right" href="view_users3.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-right"></i></a>';
			}

			echo '</b></div>'; // Đóng đoạn.

		} // Phần cuối của liên kết.

	}

	include('includes/footer.html'); ?>
	<!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
    <!-- end btn scroll top -->
	<script src="scripts/scrolltop2.js"></script>
</body>

</html>