<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Xóa tài khoản!</title>
</head>

<body id="view_user">
	<?php # Script 10.2 - delete_user.php
	// Trang này dùng để xóa hồ sơ người dùng.
	// Trang này được truy cập thông qua view_users3.php, view_detail.php.

	$page_title = 'Xóa người dùng!';
	include('session.php');
	global $tenltk;
	if ($tenltk == 'User') {
		include('includes/header_us.php');
	} else if ($tenltk == 'Admin') {
		include('includes/header_ad.php');
	} else {
		include('includes/header.php');
	}
	echo '<h1 style="color: green">Xóa người dùng</h1>';

	// Kiểm tra ID người dùng hợp lệ, thông qua GET hoặc POST:
	if ((isset($_GET['id'])) && (is_string($_GET['id']))) { // From view_users.php
		$id = $_GET['id'];
	} else if ((isset($_POST['id'])) && (is_string($_POST['id']))) { // Form submission.
		$id = $_POST['id'];
	} else { // Không có ID hợp lệ, hủy tập lệnh.
		echo '<p class="error">Trang này không được truy cập do lỗi.</p>';
		include('includes/footer.html');
		exit();
	}

	include('ketnoi.php');

	// Kiểm tra xem biểu mẫu đã được gửi chưa:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if ($_POST['sure'] == 'Yes') { // Xóa bản ghi.

			// Thực hiện truy vấn:
			$q = "DELETE FROM public.user WHERE tentk='$id'";
			$r = @pg_query($conn, $q);
			if (pg_affected_rows($r) == 1) {

				// In tin nhắn:
				echo '<p>Người dùng đã bị xóa. <a href="view_users3.php">Quay lại</a></p>';
			} else { // Nếu truy vấn không chạy được.
				echo '<p class="error">Không thể xóa người dùng do lỗi hệ thống.</p>';
			}
		} else { // Không có xác nhận xóa.
			echo '<p>Người dùng KHÔNG bị xóa. <a href="view_users3.php">Quay lại</a></p>';
		}
	} else {

		// Lấy thông tin của người dùng:
		$q = "SELECT CONCAT(tentk, ' || ',hoten, ', ', diachi) FROM public.user WHERE tentk='$id'";
		$r = @pg_query($conn, $q);

		if (pg_num_rows($r) == 1) { // ID người dùng hợp lệ, hiển thị biểu mẫu.

			// Lấy thông tin của người dùng:
			$row = pg_fetch_array($r, 0, PGSQL_NUM);

			// Hiển thị bản ghi đang bị xóa:
			echo "<h3>Tài khoản: $row[0]</h3>";
			echo '<div style="color: red; font-weight: bold; margin-bottom: 10px">Bạn có chắc chắn muốn xóa người dùng này không?</div>';

			// Tạo biểu mẫu:
			echo '<form action="delete_user.php" method="post">
		<input type="radio" name="sure" value="Yes" />  Có 
		<input type="radio" name="sure" value="No" checked="checked" style="margin-left: 10px"/>  Không
		<input type="submit" name="submit" class="btn btn-success" value="Xác nhận" style="margin-left: 10px"/>
		<input type="hidden" name="id" value="' . $id . '" />
		</form>';
		} else { // ID người dùng không hợp lệ.
			echo '<p class="error">Trang này không được truy cập do lỗi.</p>';
		}
	}

	pg_close($conn);

	include('includes/footer.html'); ?>
	<!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
    <!-- end btn scroll top -->
	<script src="scripts/scrolltop2.js"></script>
</body>

</html>