<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chỉnh sửa nhà trọ!</title>
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

<body id="view_motel">
    <?php
    $page_title = 'Chỉnh sửa nhà trọ!';
    include('session.php');
    global $tenltk;
    if ($tenltk == 'User') {
        include('includes/header_us.php');
    } else if ($tenltk == 'Admin') {
        include('includes/header_ad.php');
    } else {
        include('includes/header.php');
    }

    // Kiểm tra ID nhà trọ hợp lệ, thông qua GET hoặc POST:
    if ((isset($_GET['id'])) && (is_string($_GET['id']))) { // From view_motel.php
        $id = $_GET['id'];
    } else if ((isset($_POST['id'])) && (is_string($_POST['id']))) { // Form submission.
        $id = $_POST['id'];
    } else { // Không có ID hợp lệ, hủy tập lệnh.
        echo '<p class="error">Trang này lỗi không lấy được id nhà trọ!.</p>';
        include('includes/footer.html');
        exit();
    }

    $idnt = $id; // Lưu id nhà trọ

    if (isset($_POST['submit'])) {
        //Nhúng file kết nối với database
        include('ketnoi.php');

        //Lấy dữ liệu từ file motel_edit.php
        $duong = trim($_POST['duong']);
        $tiennghi = trim($_POST['tiennghi']);
        $lnhatro = trim($_POST['lnhatro']);
        $xaphuong = trim($_POST['xaphuong']);
        $txtX = trim($_POST['txtX']);
        $txtY = trim($_POST['txtY']);
        $txtNumber = trim($_POST['txtNumber']);
        $txtPhone = trim($_POST['txtPhone']);
        $txtDT = trim($_POST['txtDT']);
        $txtPeople = trim($_POST['txtPeople']);
        $txtNVS = trim($_POST['txtNVS']);
        $txtGP = trim($_POST['txtGP']);
        $txtTC = trim($_POST['txtTC']);
        $txtTD = trim($_POST['txtTD']);
        $txtTN = trim($_POST['txtTN']);
        $txtGG = trim($_POST['txtGG']);
        $txtSLP = trim($_POST['txtSLP']);

        $q_geom = "SELECT ST_GeomFromText('POINT($txtX $txtY)')"; // Chuyển tọa độ X,Y về dạng hình học
        $r_geom = pg_query($conn, $q_geom);
        $row_geom = pg_fetch_array($r_geom, NULL, PGSQL_ASSOC); // Lấy mảng
        $row_geom = implode(' ', $row_geom); // Chuyển mảng về chuỗi

        //Cập nhật thông tin nhà trọ vào bảng
        $qud = "UPDATE public.nhatro
        SET maduong='$duong', matn='$tiennghi', malnt='$lnhatro', maphuongxa='$xaphuong', xnhatro='$txtX', 
        ynhatro='$txtY', sonha='$txtNumber', sdt='$txtPhone', dientich='$txtDT', songuoio='$txtPeople', 
        nhavesinh='$txtNVS', giaphong='$txtGP', tiencoc='$txtTC', tiendien='$txtTD', tiennuoc='$txtTN', 
        giogiac='$txtGG', slphongtro='$txtSLP', geom='$row_geom'
        WHERE mant='$idnt';";

        $rud = @pg_query($conn, $qud);

        if (pg_affected_rows($rud) == 1) {
            echo '<h1>Thông báo</h1>';
            echo '<p class="error">Quá trình chỉnh sửa thành công!!!</p>';
        } else {
            echo '<h1>Thông báo</h1>';
            echo '<p class="error">Đã xảy ra lỗi, quá trình chỉnh sửa không thành công!!!</p>';
        }
    }

    $q = "SELECT * FROM public.nhatro WHERE mant='$idnt'";
    $r = @pg_query($conn, $q);
    if (pg_num_rows($r) == 1) { // ID nhà trọ hợp lệ.
        // Lấy thông tin của nhà trọ:
        $row = pg_fetch_array($r, 0, PGSQL_NUM);
    }

    ?>
    <h1 style="color: green">Chỉnh sửa</h1>
    <div class="con">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-dark rounded-lg my-3">
                    <div class="card-header">
                        <h3 class="text-center text-danger font-weight-bold my-1">CHỈNH SỬA NHÀ TRỌ</h3>
                    </div>
                    <div class="card-body">
                        <form action="motel_edit.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputNumber"><b>Số nhà <i class="fas fa-sort-numeric-up icon_motel"></i><font color="red">*</font></b></label>
                                <input class="form-control py-3" name="txtNumber" type="text" placeholder="Vui lòng nhập số nhà..." value="<?php echo $row[8] ?>" required />
                            </div>

                            <div class="form-row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputRoad"><b>Tên đường <i class="fas fa-road icon_motel"></i><font color="red">*</font></b></label>
                                        <select class="form-control" name="duong" required>
                                            <?php
                                            $duong =  pg_query($conn, "SELECT * FROM public.duong WHERE tenduong!=''");
                                            while ($a = pg_fetch_array($duong)) {
                                                echo "<option value='$a[maduong]'";
                                                if ($row[2] == $a['maduong'])
                                                    echo "selected='1'";
                                                echo "> $a[tenduong] </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputXP"><b>Xã phường <i class="fas fa-jedi icon_motel"></i><font color="red">*</font></b></label>
                                        <select class="form-control" name="xaphuong" required>
                                            <?php
                                            $xaphuong =  pg_query($conn, "SELECT * FROM public.xaphuong");
                                            while ($d = pg_fetch_array($xaphuong)) {
                                                echo "<option value='$d[mapx]'";
                                                if ($row[5] == $d['mapx'])
                                                    echo "selected='1'";
                                                echo "> $d[tenpx] </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputX"><b>Tọa độ X <i class="fab fa-xing-square icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtX" type="text" placeholder="Ví dụ: 109.123456..." value="<?php echo $row[6] ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputY"><b>Tọa độ Y <i class="fab fa-y-combinator icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtY" type="text" placeholder="Ví dụ: 12.123456..." value="<?php echo $row[7] ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputTNg"><b>Tiện nghi <i class="fas fa-bed icon_motel"></i><font color="red">*</font></b></label>
                                <select class="form-control" name="tiennghi" required>
                                    <?php
                                    $tiennghi =  pg_query($conn, "SELECT * FROM public.tiennghi");
                                    while ($b = pg_fetch_array($tiennghi)) {
                                        echo "<option value='$b[matn]'";
                                        if ($row[3] == $b['matn'])
                                            echo "selected='1'";
                                        echo "> $b[tentn] </option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputLNT"><b>Loại nhà trọ <i class="fas fa-house-user icon_motel"></i><font color="red">*</font></b></label>
                                        <select class="form-control" name="lnhatro" required>
                                            <?php
                                            $lnhatro =  pg_query($conn, "SELECT * FROM public.loainhatro");
                                            while ($c = pg_fetch_array($lnhatro)) {
                                                echo "<option value='$c[malnt]'";
                                                if ($row[4] == $c['malnt'])
                                                    echo "selected='1'";
                                                echo "> $c[tenlnt] </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputPhoneNumber"><b>Số điện thoại <i class="fas fa-phone-square-alt icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtPhone" type="number" placeholder="0123456789..." value="<?php echo trim($row[9]) ?>" pattern="^[0-9]{10,11}$" maxlength="11" required title="Vui lòng nhập đúng số điện thoại." />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputDT"><b>Diện tích (m2) <i class="fas fa-ruler icon_motel"></i><font color="red">*</font></b></label>
                                <input class="form-control py-3" name="txtDT" type="number" aria-describedby="AddressHelp" placeholder="Ví dụ: 15" value="<?php echo $row[10] ?>" required />
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputPeople"><b>Số người ở tối đa <i class="fas fa-user-circle icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtPeople" type="text" placeholder="Ví dụ: 5 hoặc 3 đến 5" value="<?php echo $row[11] ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputNVS"><b>Nhà vệ sinh <i class="fas fa-toilet icon_motel"></i><font color="red">*</font></b></label>
                                        <select class="form-control" name="txtNVS" required>
                                            <?php
                                            echo '<option value="Riêng" ';
                                            if ($row[12] == 'Riêng') echo "selected";
                                            echo '> Riêng </option>
                                               <option value="Chung" ';
                                            if ($row[12] == 'Chung') echo "selected";
                                            echo '> Chung </option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputGP"><b>Giá phòng / tháng <i class="fas fa-money-check-alt icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtGP" type="number" placeholder="Ví dụ: 1000000" value="<?php echo $row[13] ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTC"><b>Tiền cọc <i class="fas fa-funnel-dollar icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtTC" type="number" placeholder="Ví dụ: 500000" value="<?php echo $row[14] ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTD"><b>Tiền điện / 1 kWh <i class="fas fa-charging-station icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtTD" type="number" placeholder="Ví dụ: 5000" value="<?php echo $row[15] ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTN"><b>Tiền nước / m3 <i class="fas fa-faucet icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtTN" type="number" placeholder="Ví dụ: 14000" value="<?php echo $row[16] ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputGG"><b>Giờ giấc (mở cửa-đóng cửa) <i class="fas fa-business-time icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtGG" type="text" placeholder="Ví dụ: 6h - 23h hoặc Tự do" value="<?php echo $row[17] ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputSLP"><b>Số lượng phòng trống <i class="fas fa-calendar-check icon_motel"></i><font color="red">*</font></b></label>
                                        <input class="form-control py-3" name="txtSLP" type="number" placeholder="Vui lòng nhập số lượng..." value="<?php echo $row[18] ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-10">
                                    <div class="form-group mt-4 mb-0">
                                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Chỉnh sửa nhà trọ" />
                                        <input type="hidden" name="id" value="<?php echo $idnt ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-4 mb-0">
                                        <button><a class="form-control" style="background: red; color: white;" href="view_motel.php">
                                                Quay lại</a></button>
                                    </div>
                                </div>
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