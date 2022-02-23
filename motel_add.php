<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Đăng ký nhà trọ!</title>
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
    $page_title = 'Đăng ký!';
    include('session.php');
    global $tenltk;
    if ($tenltk == 'User') {
        include('includes/header_us.php');
    } else if ($tenltk == 'Admin') {
        include('includes/header_ad.php');
    } else {
        include('includes/header.php');
    }

    if (isset($_POST['submit'])) {
        //Nhúng file kết nối với database
        include('ketnoi.php');

        //Lấy dữ liệu từ file motel_add.php
        $id =  $maid;
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

        // Mã nhà trọ
        // Câu lệnh lấy mã nhà trọ cuối cùng
        $qnt = "SELECT mant from public.nhatro ORDER BY mant DESC LIMIT 1";
        $rnt = @pg_query($conn, $qnt); // Run the query.

        $rownt = pg_fetch_array($rnt, NULL, PGSQL_ASSOC);
        $rownt = implode(' ', $rownt); // Chuyển mảng thành chuỗi
        $user_nt = substr($rownt, -3); // Tách lấy số trong mã nhà trọ

        $ma = 'NT';
        $nt = $user_nt + 1; // Tăng mã lên 1 số
        $nt = str_pad($nt, 3, '0', STR_PAD_LEFT); // Giữ số 0 tới 3 chữ số

        $result_nt = $ma . '' . $nt; // Ghép nối mã với số đã tăng
        // End mã nhà trọ

        $q_geom = "SELECT ST_GeomFromText('POINT($txtX $txtY)')"; // Chuyển tọa độ X,Y về dạng hình học
        $r_geom = pg_query($conn, $q_geom);
        $row_geom = pg_fetch_array($r_geom, NULL, PGSQL_ASSOC); // Lấy mảng
        $row_geom = implode(' ', $row_geom); // Chuyển mảng về chuỗi

        //Lưu thông tin thành viên vào bảng
        @$addnhatro = pg_query($conn, "
            INSERT INTO public.nhatro (
                mant, id, maduong, matn, malnt, maphuongxa, xnhatro, ynhatro, sonha, sdt, dientich, songuoio, 
                nhavesinh, giaphong, tiencoc, tiendien, tiennuoc, giogiac, slphongtro, geom
            )
            VALUES (
                '{$result_nt}', '{$id}', '{$duong}', '{$tiennghi}', '{$lnhatro}', '{$xaphuong}', '{$txtX}',  
                '{$txtY}', '{$txtNumber}', '{$txtPhone}', '{$txtDT}', '{$txtPeople}', '{$txtNVS}', '{$txtGP}',  
                '{$txtTC}', '{$txtTD}', '{$txtTN}', '{$txtGG}', '{$txtSLP}', '{$row_geom}'
            )");
        //Thông báo quá trình lưu
        if ($addnhatro) {
            echo '<h1>Thông báo</h1>';
            echo '<p class="error">Quá trình đăng ký thành công!!!</p>';
        } else {
            echo '<h1>Thông báo</h1>';
            echo '<p class="error">Đã xảy ra lỗi, quá trình đăng ký không thành công!!!</p>';
        }
    }

    ?>
    <h1 style="color: green">Đăng ký</h1>
    <div class="con">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-dark rounded-lg my-3">
                    <div class="card-header">
                        <h3 class="text-center text-danger font-weight-bold my-1">THÊM NHÀ TRỌ</h3>
                    </div>
                    <div class="card-body">
                        <form action="motel_add.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputNumber"><b>Số nhà <i class="fas fa-sort-numeric-up icon_motel"></i>
                                        <font color="red">*</font>
                                    </b></label>
                                <input class="form-control py-3" name="txtNumber" type="text" placeholder="Vui lòng nhập số nhà..." value="<?php if (isset($_POST['txtNumber'])) echo $_POST['txtNumber']; ?>" required />
                            </div>

                            <div class="form-row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputRoad"><b>Tên đường <i class="fas fa-road icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <select class="form-control" name="duong" required>
                                            <option value=""></option>
                                            <?php
                                            $duong =  pg_query($conn, "SELECT * FROM public.duong WHERE tenduong!=''");
                                            while ($a = pg_fetch_array($duong)) {
                                                echo "<option value='$a[maduong]'";
                                                if ((isset($_POST['duong'])) && $_POST['duong'] == $a['maduong'])
                                                    echo "selected='1'";
                                                echo "> $a[tenduong] </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputXP"><b>Xã phường <i class="fas fa-jedi icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <select class="form-control" name="xaphuong" required>
                                            <option value=""></option>
                                            <?php
                                            $xaphuong =  pg_query($conn, "SELECT * FROM public.xaphuong");
                                            while ($d = pg_fetch_array($xaphuong)) {
                                                echo "<option value='$d[mapx]'";
                                                if ((isset($_POST['xaphuong'])) && $_POST['xaphuong'] == $d['mapx'])
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
                                        <label class="medium mb-1 motel" for="inputX"><b>Tọa độ X <i class="fab fa-xing-square icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtX" type="text" placeholder="Ví dụ: 109.123456..." value="<?php if (isset($_POST['txtX'])) echo $_POST['txtX']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputY"><b>Tọa độ Y <i class="fab fa-y-combinator icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtY" type="text" placeholder="Ví dụ: 12.123456..." value="<?php if (isset($_POST['txtY'])) echo $_POST['txtY']; ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputTNg"><b>Tiện nghi <i class="fas fa-bed icon_motel"></i>
                                        <font color="red">*</font>
                                    </b></label>
                                <select class="form-control" name="tiennghi" required>
                                    <option value=""></option>
                                    <?php
                                    $tiennghi =  pg_query($conn, "SELECT * FROM public.tiennghi");
                                    while ($b = pg_fetch_array($tiennghi)) {
                                        echo "<option value='$b[matn]'";
                                        if ((isset($_POST['tiennghi'])) && $_POST['tiennghi'] == $b['matn'])
                                            echo "selected='1'";
                                        echo "> $b[tentn] </option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputLNT"><b>Loại nhà trọ <i class="fas fa-house-user icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <select class="form-control" name="lnhatro" required>
                                            <option value=""></option>
                                            <?php
                                            $lnhatro =  pg_query($conn, "SELECT * FROM public.loainhatro");
                                            while ($c = pg_fetch_array($lnhatro)) {
                                                echo "<option value='$c[malnt]'";
                                                if ((isset($_POST['lnhatro'])) && $_POST['lnhatro'] == $c['malnt'])
                                                    echo "selected='1'";
                                                echo "> $c[tenlnt] </option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputPhoneNumber"><b>Số điện thoại <i class="fas fa-phone-square-alt icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtPhone" type="number" placeholder="0123456789..." value="<?php if (isset($_POST['txtPhone'])) echo $_POST['txtPhone']; ?>" pattern="^[0-9]{10,11}$" maxlength="11" required title="Vui lòng nhập đúng số điện thoại." />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="medium mb-1 motel" for="inputDT"><b>Diện tích (m2) <i class="fas fa-ruler icon_motel"></i>
                                        <font color="red">*</font>
                                    </b></label>
                                <input class="form-control py-3" name="txtDT" type="number" aria-describedby="AddressHelp" placeholder="Ví dụ: 16" value="<?php if (isset($_POST['txtDT'])) echo $_POST['txtDT']; ?>" required />
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputPeople"><b>Số người ở tối đa <i class="fas fa-user-circle icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtPeople" type="text" placeholder="Ví dụ: 5 hoặc 3 đến 5" value="<?php if (isset($_POST['txtPeople'])) echo $_POST['txtPeople']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputNVS"><b>Nhà vệ sinh <i class="fas fa-toilet icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <select class="form-control" name="txtNVS" required>
                                            <option value=""> </option>
                                            <option value="Riêng">Riêng</option>
                                            <option value="Chung">Chung</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputGP"><b>Giá phòng / tháng <i class="fas fa-money-check-alt icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtGP" type="number" placeholder="Ví dụ: 1000000" value="<?php if (isset($_POST['txtGP'])) echo $_POST['txtGP']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTC"><b>Tiền cọc <i class="fas fa-funnel-dollar icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtTC" type="number" placeholder="Ví dụ: 500000" value="<?php if (isset($_POST['txtTC'])) echo $_POST['txtTC']; ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTD"><b>Tiền điện / 1 kWh <i class="fas fa-charging-station icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtTD" type="number" placeholder="Ví dụ: 5000" value="<?php if (isset($_POST['txtTD'])) echo $_POST['txtTD']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputTN"><b>Tiền nước / m3 <i class="fas fa-faucet icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtTN" type="number" placeholder="Ví dụ: 14000" value="<?php if (isset($_POST['txtTN'])) echo $_POST['txtTN']; ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputGG"><b>Giờ giấc (mở cửa-đóng cửa) <i class="fas fa-business-time icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtGG" type="text" placeholder="Ví dụ: 6h - 23h hoặc Tự do" value="<?php if (isset($_POST['txtGG'])) echo $_POST['txtGG']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="medium mb-1 motel" for="inputSLP"><b>Số lượng phòng trống <i class="fas fa-calendar-check icon_motel"></i>
                                                <font color="red">*</font>
                                            </b></label>
                                        <input class="form-control py-3" name="txtSLP" type="number" placeholder="Vui lòng nhập số lượng..." value="<?php if (isset($_POST['txtSLP'])) echo $_POST['txtSLP']; ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4 mb-0">
                                <input type="submit" name="submit" class="btn btn-primary btn-block motel" value="Thêm nhà trọ" />
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