<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Đăng ký!</title>
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

<body id="dangki">
  <?php
  $page_title = 'Đăng ký!';
  include('ses2.php');
  global $tenltk;
  if ($tenltk == 'User') {
    include('includes/header_us.php');
  } else if ($tenltk == 'Admin') {
    include('includes/header_ad.php');
  } else {
    include('includes/header.php');
  }

  $erors_user1 = "";
  $erors_user2 = "";
  $erors_pass1 = "";
  $erors_pass2 = "";
  $erors_address = "";
  $erors_fullname = "";
  $erors_phone = "";
  $erors_avatar = "";
  $erors_gender = "";

  $isValue = true;

  if (isset($_POST['submit'])) {
    // Nếu không phải là sự kiện đăng ký thì không xử lý
    if (!isset($_POST['txtTentk'])) {
      die('');
    }

    //Nhúng file kết nối với database
    include('ketnoi.php');

    //Lấy dữ liệu từ file dangky.php
    $tentk   = addslashes($_POST['txtTentk']);
    $password   = addslashes($_POST['txtPassword']);
    $pass2   = addslashes($_POST['txtPassword2']);
    $address      = addslashes($_POST['txtAddress']);
    $fullname   = addslashes($_POST['txtFullname']);
    $phone   = addslashes($_POST['txtPhone']);
    $avatar     = $_FILES['avatar']['name'];
    $gender        = addslashes($_POST['txtGender']);
    $maltk       = 'LTK002';
    $quyentk = true;

    //Kiểm tra người dùng đã nhập liệu đầy đủ chưa
    if (!$tentk) {
      $erors_user1 = ("<font color='red'>Vui lòng nhập tên tài khoản!</font>");
      $isValue = false;
    }

    if ($password) {
      if ($password != $pass2) {
        $erors_pass2 =  ("<font color='red'>Mật khẩu không khớp. Vui lòng nhập lại!</font>");
        $isValue = false;
      }
    } else {
      $erors_pass1 =  ("<font color='red'>Vui lòng nhập đầy đủ mật khẩu!</font>");
      $isValue = false;
    }

    if (!$address) {
      $erors_address = ("<font color='red'>Vui lòng nhập vào địa chỉ!</font>");
      $isValue = false;
    }

    if (!$fullname) {
      $erors_fullname = ("<font color='red'>Vui lòng nhập đầy đủ họ và tên!</font>");
      $isValue = false;
    }

    if (!$phone) {
      $erors_phone = ("<font color='red'>Vui lòng nhập số điện thoại!</font>");
      $isValue = false;
    }

    if (!$gender) {
      $erors_gender = ("<font color='red'>Vui lòng chọn giới tính!</font>");
      $isValue = false;
    }

    // Mã khóa mật khẩu
    // $password = md5($password);

    // Mã User
    // Câu lệnh lấy mã user cuối cùng
    $qid = "SELECT id from public.user ORDER BY id DESC LIMIT 1";
    $rid = @pg_query($conn, $qid); // Run the query.

    $rowid = pg_fetch_array($rid, NULL, PGSQL_ASSOC);
    $rowid = implode(' ', $rowid); // Chuyển mảng thành chuỗi
    $user_id = substr($rowid, -3); // Tách lấy số trong mã user

    $ma = 'US';
    $id = $user_id + 1; // Tăng mã lên 1 số
    $id = str_pad($id, 3, '0', STR_PAD_LEFT); // Giữ số 0 tới 3 chữ số

    $result_id = $ma . '' . $id; // Ghép nối mã với số đã tăng
    // End mã user

    //Kiểm tra tên đăng nhập này đã có người dùng chưa
    if (pg_num_rows(pg_query($conn, "SELECT tentk FROM public.user WHERE tentk='$tentk'")) > 0) {
      $erors_user2 = ("<font color='red'>Tên tài khoản này đã có người dùng. Vui lòng chọn tên tài khoản khác!</font>");
      $isValue = false;
    }

    if ($_FILES['avatar']['name'] != NULL) {
      $expensions = array("jpeg", "jpg", "png");
      // Lấy đuôi file
      $file_ext = substr($avatar, strpos($avatar, '.') + 1);

      $file_size = $_FILES['avatar']['size'];

      if ($file_size > 2097152) {
        echo '<p class="error">Kích thước file phải nhỏ hơn 2MB!</p>';
        $isValue = false;
      }

      if (in_array($file_ext, $expensions) === false) {
        echo '<p class="error">Chỉ hỗ trợ upload file JPEG hoặc PNG!</p>';
        $isValue = false;
      } else
        move_uploaded_file(
          $_FILES["avatar"]["tmp_name"],
          "../WebGisNT_DauQuangLoc_59131309/images/" . $_FILES["avatar"]["name"]
        );
    } else {
      $erors_avatar = ("<font color='red'></br>Vui lòng chọn file upload!</font>");
      $isValue = false;
    }

    if ($isValue) {
      //Lưu thông tin thành viên vào bảng
      @$adduser = pg_query($conn, "
            INSERT INTO public.user (
                id,
                maltk,
                tentk,
                matkhau,
                hoten,
                diachi,
                sdt,
                quyentk,
                avatar,
                gtinh
            )
            VALUES (
                '{$result_id}',
                '{$maltk}',
                '{$tentk}',
                '{$password}',
                '{$fullname}',
                '{$address}',
                '{$phone}',
                '{$quyentk}',
                '{$avatar}',
                '{$gender}'
            )
        ");

      //Thông báo quá trình lưu
      if ($adduser) {
        echo '<h1>Thông báo</h1>';
        echo '<p class="error">Quá trình đăng ký thành công. <a href="login.php">Đăng nhập</a></p>';
      } else {
        echo '<h1>Thông báo</h1>';
        echo '<p class="error">Có lỗi xảy ra trong quá trình đăng ký. <a href="dangki.php">Thử lại</a></p>';
      }
    }
  }

  ?>
  <h1 style="color: green">Đăng ký</h1>
  <div class="con">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-lg border-dark rounded-lg my-3">
          <div class="card-header">
            <h3 class="text-center text-danger font-weight-bold my-1">ĐĂNG KÝ TÀI KHOẢN</h3>
          </div>
          <div class="card-body">
            <form action="dangki.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="medium mb-1" for="inputAddress"><b>Tên tài khoản: <font color="red">*</font></b></label>
                <input class="form-control py-3" name="txtTentk" type="text" aria-describedby="AddressHelp" placeholder="Nhập tên tài khoản..." value="<?php if (isset($_POST['txtTentk'])) echo $_POST['txtTentk']; ?>" />
                <?php echo $erors_user1; ?>
                <?php echo $erors_user2; ?>
              </div>
              <div class="form-group">
                <label class="medium mb-1" for="inputAddress"><b>Họ và tên: <font color="red">*</font></b></label>
                <input class="form-control py-3" name="txtFullname" type="text" aria-describedby="AddressHelp" placeholder="Nhập họ và tên..." value="<?php if (isset($_POST['txtFullname'])) echo $_POST['txtFullname']; ?>" />
                <?php echo $erors_fullname; ?>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="medium mb-1" for="inputPassword"><b>Mật khẩu: <font color="red">*</font></b></label>
                    <input class="form-control py-3" name="txtPassword" type="password" placeholder="Nhập mật khẩu..." value="<?php if (isset($_POST['txtPassword'])) echo $_POST['txtPassword']; ?>" />
                    <?php echo $erors_pass1; ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="medium mb-1" for="inputConfirmPassword"><b>Xác nhận mật khẩu: <font color="red">*</font></b></label>
                    <input class="form-control py-3" name="txtPassword2" type="password" placeholder="Nhập lại mật khẩu..." value="<?php if (isset($_POST['txtPassword2'])) echo $_POST['txtPassword2']; ?>" />
                    <?php echo $erors_pass2; ?>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="medium mb-1" for="inputPhoneNumber"><b>Số điện thoại: <font color="red">*</font></b></label>
                    <input class="form-control py-3" name="txtPhone" type="number" placeholder="" value="<?php if (isset($_POST['txtPhone'])) echo $_POST['txtPhone']; ?>" />
                    <?php echo $erors_phone; ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="medium mb-1" for="inputGender"><b>Giới tính: <font color="red">*</font></b></label>
                    </br>
                    <input class="py-4 mt-3" type="radio" name="txtGender" value="Nam" / checked="checked"> Nam
                    <input class="py-4" style="margin-left: 15px" type="radio" name="txtGender" value="Nữ" /> Nữ
                    <?php echo $erors_gender; ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="medium mb-1" for="inputAddress"><b>Địa chỉ: <font color="red">*</font></b></label>
                <input class="form-control py-3" name="txtAddress" type="Address" aria-describedby="AddressHelp" placeholder="Nhập địa chỉ..." value="<?php if (isset($_POST['txtAddress'])) echo $_POST['txtAddress']; ?>" />
                <?php echo $erors_address; ?>
              </div>
              <div class="form-group">
                <label class="medium mb-1" for="inputAvatar"><b>Hình ảnh: <font color="red">*</font></b></label>
                </br>
                <input class="py-1" name="avatar" type="file" style="width: 100%; border: 1px solid #CCC7C7; border-radius: 5px" />
                <?php echo $erors_avatar; ?>
              </div>
              <div class="form-group mt-4 mb-0">
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Tạo tài khoản" />
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <div class="medium"><a href="login.php">Bạn đã có tài khoản? Đăng nhập</a></div>
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