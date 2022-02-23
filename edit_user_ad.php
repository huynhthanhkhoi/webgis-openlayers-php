<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chỉnh sửa người dùng!</title>
</head>

<body id="view_user">
	<?php # Script 10.3 - edit_user_ad.php
	// Trang này là để chỉnh sửa hồ sơ người dùng dành cho Admin.
	// Trang này được truy cập thông qua view_users3.php.

	$page_title = 'Chỉnh sửa người dùng';
	include('session.php');
	global $tenltk;
	if ($tenltk == 'User') {
		include('includes/header_us.php');
	} else if ($tenltk == 'Admin') {
		include('includes/header_ad.php');
	} else {
		include('includes/header.php');
	}
	echo '<h1 style="color: green">Chỉnh sửa người dùng</h1>';

	// Kiểm tra ID người dùng hợp lệ, thông qua GET hoặc POST:
	if ((isset($_GET['id'])) && (is_string($_GET['id']))) { // From view_users.php
		$id = $_GET['id'];
	} else if ((isset($_POST['id'])) && (is_string($_POST['id']))) { // Form submission.
		$id = $_POST['id'];
	} else { // Không có ID hợp lệ, hủy tập lệnh.
		echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
		include('includes/footer.html');
		exit();
	}

	include('ketnoi.php');

	// Kiểm tra xem biểu mẫu đã được gửi chưa:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$errors = array();

		// Kiểm tra tên:
		if (empty($_POST['hoten'])) {
			$errors[] = 'Bạn quên nhập tên đầy đủ của mình!';
		} else {
			$fn = trim($_POST['hoten']);
		}

		// Kiểm tra địa chỉ:
		if (empty($_POST['diachi'])) {
			$errors[] = 'Bạn quên nhập địa chỉ của mình!';
		} else {
			$e = trim($_POST['diachi']);
		}

		// Kiểm tra số điện thoại:
		if (empty($_POST['sdt'])) {
			$errors[] = 'Bạn quên nhập số điện thoại của mình!';
		} else {
			$dob = trim($_POST['sdt']);
		}

		$avatar = $_FILES['avatar']['name'];

		if ($_FILES['avatar']['name'] != NULL) {
			$expensions = array("jpeg", "jpg", "png");
			// lay duoi file
			$file_ext = substr($avatar, strpos($avatar, '.') + 1);

			$file_size = $_FILES['avatar']['size'];

			if ($file_size > 2097152) {
				$errors[] = "Kích thước file phải nhỏ hơn 2MB!";
			}

			if (in_array($file_ext, $expensions) === false) {
				$errors[] = "Chỉ hỗ trợ upload file JPEG hoặc PNG.";
			} else {
				move_uploaded_file(
					$_FILES["avatar"]["tmp_name"],
					"../WebGisNT_DauQuangLoc_59131309/images/" . $_FILES["avatar"]["name"]
				);

				$at = trim($avatar);
			}
		} else {
			// Lấy avatar của người dùng:
			$q = "SELECT avatar FROM public.user WHERE tentk='$id'";
			$r = @pg_query($conn, $q);

			if (pg_num_rows($r) == 1) { // ID người dùng hợp lệ, hiển thị biểu mẫu.

				// Lấy avatar của người dùng:
				$row = pg_fetch_array($r, 0, PGSQL_NUM);
				$at = $row[0];
			}
		}

		// Kiểm tra giới tính:
		if (empty($_POST['gtinh'])) {
			$errors[] = 'Bạn quên nhập giới tính của mình!';
		} else {
			$s = trim($_POST['gtinh']);
		}

		$qtk = trim($_POST['txtQuyen']);

		if (empty($errors)) { // Nếu không lỗi
			$qud = "UPDATE public.user SET hoten='$fn', diachi='$e', sdt='$dob', avatar='$at', gtinh='$s', quyentk='$qtk' WHERE tentk='$id'";
			$rud = @pg_query($conn, $qud);
			if (pg_affected_rows($rud) == 1) {
				echo "<p><b><font size='4' color='green'>Thông tin người dùng đã được cập nhật!</font></b></p>";
			} else {
				echo "<p><b><font size='4' color='green'>Không có sự thay đổi thông tin!</font></b></p>";
			}
		} else { // Báo cáo các lỗi.

			echo '<p class="error">Đã xảy ra (các) lỗi sau:<br />';
			foreach ($errors as $msg) { // In từng lỗi.
				echo " - $msg<br />\n";
			}
			echo "<p><b><font size='4' color='green'>Vui lòng thử lại!</font></b></p>";
		} // Kết thúc if (empty($errors)) IF.

	} // Kết thúc gửi có điều kiện.

	// Luôn hiển thị form ...

	// Lấy thông tin của người dùng:
	$q = "SELECT  tentk, hoten, sdt, avatar, gtinh, diachi, quyentk FROM public.user WHERE tentk='$id'";
	$r = @pg_query($conn, $q);

	if (pg_num_rows($r) == 1) { // ID người dùng hợp lệ, hiển thị biểu mẫu.

		// Lấy thông tin của người dùng:
		$row = pg_fetch_array($r, 0, PGSQL_NUM);

		// Tạo biểu mẫu:
		echo '<form action="edit_user_ad.php" method="post" style="width: 900px; margin: 0 auto" enctype="multipart/form-data">
        <table class="table table-borderless table-success" align="center" style="width: 900px; margin-top: 20px;">
          <tr bgcolor="green">
            <th colspan="3" style="text-align: center; font-size: 20pt; color: white">
            CHỈNH SỬA HỒ SƠ</th>
          </tr>
          
          <tr> 
            <td rowspan="8">
            	<img src="images/' . $row[3] . '" width="250" height="350" style="margin-top: 15px" />
            	<input type="hidden" name="avatar" value="' . $row[3] . '" />
            </td>
          </tr>
          
          <tr>
            <td><b>Tên tài khoản: <font color="red">*</font></b></td>
            <td>
                <input class="form-control" type="text" name="tentk" size= "50" disabled
                value="' . $row[0] . '" />
            </td>
          </tr>

          <tr>
            <td><b>Họ và tên: <font color="red">*</font></b></td>
            <td>
                <input class="form-control" type="text" name="hoten" size= "50" 
                value="' . $row[1] . '" />
            </td>
          </tr>

          <tr>
            <td><b>Số điện thoại: <font color="red">*</font></b></td>
            <td>
                <input class="form-control" type="text" name="sdt" size= "50" 
                value="' . trim($row[2]) . '" pattern="^[0-9]{10,11}$" maxlength="11" required title="Vui lòng nhập đúng số điện thoại."/>
            </td>
          </tr>
          
          <tr>
            <td><b>Hình ảnh: <font color="red">*</font></b></td>
            <td>
                <input type="file" name="avatar" size= "50" style="width: 100%; border: 1px solid #CCC7C7; border-radius: 5px"/>
            </td>
          </tr>

          <tr>
            <td><b>Giới tính: <font color="red">*</font></b></td>
            <td>
            <input type="radio" name="gtinh" value="Nam" ';
		if ($row[4] == "Nam") echo  "checked='1'";
		echo '/> Nam
			<input type="radio" style="margin-left: 10px" name="gtinh" value="Nữ" ';
		if ($row[4] == "Nữ") echo  "checked='1'";
		echo '/> Nữ
            </td>
          </tr>

		  <tr>
            <td><b>Địa chỉ: <font color="red">*</font></b></td>
            <td>
                <input class="form-control" type="text" name="diachi" size= "50" 
                value="' . $row[5] . '" />
            </td>
          </tr>

		  <tr>
            <td><b>Quyền hoạt động: <font color="red">*</font></b></td>
            <td>
				<select class="form-control" name="txtQuyen">
					<option value="1" ';
		if ($row[6] == 't') echo "selected";
		echo '> Kích hoạt </option>
                	<option value="0" ';
		if ($row[6] == 'f') echo "selected";
		echo '> Vô hiệu hóa </option>
		  		</select>
            </td>
          </tr>
          
          <tr>
            <td colspan="3" align="left">
                <input type="submit" name="submit" class="btn btn-primary" value="Xác nhận" />
                <input type="hidden" name="id" value="' . $id . '" />

                <button><a class="form-control" style="background: red; color: white;" href="view_users3.php">
            	Quay lại</a></button>
            </td>
          </tr>

        </table>
    </form>';
	} else { // ID người dùng không hợp lệ.
		echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
	}

	pg_close($conn);

	include('includes/footer.html'); ?>
	<!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
    <!-- end btn scroll top -->
	<script src="scripts/scrolltop2.js"></script>
</body>

</html>