<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title>Đổi mật khẩu!</title>
</head>

<style type="text/css">
	.con {
		border-radius: 5px;
		width: 100%;
		margin: 0 auto;
		height: 100%;
		margin-bottom: -20px;
	}
</style>

<body id="password">
	<?php # Script 9.7 - password.php
	// Trang này cho phép quản trị viên thay đổi mật khẩu của người dùng.

	$page_title = 'Đổi mật khẩu!';
	include('session.php');
	global $tenltk;
	if ($tenltk == 'User') {
		include('includes/header_us.php');
	} else if ($tenltk == 'Admin') {
		include('includes/header_ad.php');
	} else {
		include('includes/header.php');
	}

	// Kiểm tra việc gửi biểu mẫu:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		//Nhúng file kết nối với database
		include('ketnoi.php');

		$errors = array(); // Khởi tạo một mảng lỗi.

		// Kiểm tra tên người dùng:
		if (empty($_POST['tentk'])) {
			$errors[] = 'Bạn quên nhập tên người dùng của mình!';
		} else {
			$u = pg_escape_string($conn, trim($_POST['tentk']));
		}

		// Kiểm tra mật khẩu hiện tại:
		if (empty($_POST['pass'])) {
			$errors[] = 'Bạn quên nhập mật khẩu hiện tại của mình!';
		} else {
			$p = pg_escape_string($conn, trim($_POST['pass']));
		}

		// Kiểm tra mật khẩu mới và khớp
		// chống lại mật khẩu xác nhận:
		if (!empty($_POST['pass1'])) {
			if ($_POST['pass1'] != $_POST['pass2']) {
				$errors[] = 'Mật khẩu mới của bạn không khớp với mật khẩu đã xác nhận!';
			} else {
				$np = pg_escape_string($conn, trim($_POST['pass1']));
			}
		} else {
			$errors[] = 'Bạn quên nhập mật khẩu mới của mình!';
		}

		if (empty($errors)) {

			// Kiểm tra xem họ đã nhập đúng địa chỉ email / kết hợp mật khẩu chưa:
			$q = "SELECT tentk FROM public.user WHERE (tentk='$u' AND matkhau='$p')";
			$r = @pg_query($conn, $q);
			$num = @pg_num_rows($r);
			if ($num == 1) { // Đã được thực hiện.

				// Lấy tên người dùng:
				$row = pg_fetch_array($r, 0, PGSQL_NUM);

				// Thực hiện truy vấn CẬP NHẬT:
				$q = "UPDATE public.user SET matkhau='$np' WHERE tentk='$u'";
				$r = @pg_query($conn, $q);
				if (pg_affected_rows($r) == 1) {
					// In tin nhắn.
					echo '<h1>Thank you!</h1>
				<p class="error">
					<b>
						<font size="4" color="green">Mật khẩu của bạn đã được cập nhật. Vui lòng <a href="login2.php">đăng nhập</a> với mật khẩu mới!</font>
					</b>
				<br /></p>';
				} else {

					// Tin nhắn công khai:
					echo '<h1>System Error</h1>
				<p class="error">Không thể thay đổi mật khẩu của bạn do lỗi hệ thống. Chúng tôi xin lỗi vì sự bất tiện này!</p>';

					// Thông báo gỡ lỗi:
					// echo '<p>' . pg_error($conn) . '<br /><br />Query: ' . $q . '</p>';

				}

				pg_close($conn);

				// Bao gồm chân trang và thoát khỏi tập lệnh (để không hiển thị biểu mẫu).
				include('includes/footer.html');
				exit();
			} else { // Địa chỉ email / mật khẩu kết hợp không hợp lệ.
				echo '<h1>Error!</h1>
			<p class="error">
			Tên tài khoản và mật khẩu hiện tại không khớp với thông tin trong hồ sơ.</p>';
			}
		} else { // Báo cáo các lỗi.

			echo '<h1>Error!</h1>
		<p class="error">Đã xảy ra (các) lỗi sau:<br />';
			foreach ($errors as $msg) {
				echo " - $msg<br />\n";
			}
			echo "<p><b><font size='4' color='green'>Vui lòng thử lại!</font></b></p>";
		}

		pg_close($conn);
	}
	?>
	<h1 style="color: green">Thay đổi mật khẩu của bạn</h1>
	<div class="con">
		<div class="row justify-content-center">
			<div class="col-lg-7">
				<div class="card shadow-lg border-dark rounded-lg my-3">
					<div class="card-header">
						<h3 class="text-center text-danger font-weight-bold my-1">THAY ĐỔI MẬT KHẨU</h3>
					</div>
					<div class="card-body">
						<form action="password.php" method="post">
							<div class="form-group">
								<label class="medium mb-1" for="inputEmailAddress"><b>Tên tài khoản: <font color="red">*</font></b></label>
								<input class="form-control py-3" name="tentk" type="text" aria-describedby="emailHelp" placeholder="Nhập tên tài khoản..." value="<?php if (isset($_POST['tentk'])) echo $_POST['tentk']; ?>" />
							</div>

							<div class="form-group">
								<label class="medium mb-1" for="inputPassword"><b>Mật khẩu hiện tại: <font color="red">*</font></b></label>
								<input class="form-control py-3" name="pass" type="password" placeholder="Nhập mật khẩu hiện tại..." value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" />
							</div>

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="medium mb-1" for="inputPassword"><b>Mật khẩu mới: <font color="red">*</font></b></label>
										<input class="form-control py-3" name="pass1" type="password" placeholder="Nhập mật khẩu mới..." value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="medium mb-1" for="inputConfirmPassword"><b>Xác nhận mật khẩu mới: <font color="red">*</font></b></label>
										<input class="form-control py-3" name="pass2" type="password" placeholder="Nhập lại mật khẩu..." value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" />
									</div>
								</div>
							</div>

							<div class="form-group mt-4 mb-0">
								<input type="submit" name="submit" class="btn btn-primary btn-block" value="Xác nhận" />
							</div>
						</form>
					</div>
					<div class="card-footer text-center">
						<div class="medium"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.html'); ?>
	<!-- btn scroll top -->
	<div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
	<!-- end btn scroll top -->
	<script src="scripts/scrolltop2.js"></script>
</body>

</html>