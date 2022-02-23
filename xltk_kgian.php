<?php
if ((isset($_GET['xp'])) && (is_string($_GET['xp']))) { // From map2.js
    $xp = $_GET['xp'];
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}

if ((isset($_GET['lchon'])) && (is_string($_GET['lchon']))) { // From map2.js
    $lchon = $_GET['lchon'];
}

if ((isset($_GET['bkinh'])) && (is_string($_GET['bkinh']))) { // From map2.js
    $bkinh = $_GET['bkinh'];
}
if ($bkinh == null) { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Vui lòng nhập vào ô bán kính !</p>';
    exit();
}

if ((isset($_GET['tentr'])) && (is_string($_GET['tentr']))) { // From map2.js
    $tentr = $_GET['tentr'];
}

// Tên đường
if ((isset($_GET['tduong'])) && (is_string($_GET['tduong']))) { // From tknangcao.php
    $tduong = $_GET['tduong'];
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Tên đường

// Loại nhà trọ
if ((isset($_GET['lphong'])) && (is_string($_GET['lphong']))) { // From tknangcao.php
    $lphong = $_GET['lphong'];
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Loại nhà trọ

// Diện tích
if ((isset($_GET['dtich'])) && (is_string($_GET['dtich']))) { // From tknangcao.php
    $dtich = $_GET['dtich'];
    $dtich_id = strtok($dtich, " ");
    $dtich_sub = substr($dtich, strpos($dtich, ' ') + strlen(' '));

    if (empty($dtich)) {
        $dtich_sql = " ";
    } else {
        if ('=' == $dtich_id || '>' == $dtich_id || '<' == $dtich_id || '>=' == $dtich_id || '<=' == $dtich_id) {
            $dtich_sql = "AND dientich $dtich_id '$dtich_sub'";
        } else {
            $dtich_sql = "AND dientich = '$dtich'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Diện tích

// Giá phòng
if ((isset($_GET['gphong'])) && (is_string($_GET['gphong']))) { // Form submission.
    $gphong = $_GET['gphong'];
    $gphong_id = strtok($gphong, " ");
    $gphong_sub = substr($gphong, strpos($gphong, ' ') + strlen(' '));

    if (empty($gphong)) {
        $gphong_sql = " ";
    } else {
        if ('=' == $gphong_id || '>' == $gphong_id || '<' == $gphong_id || '>=' == $gphong_id || '<=' == $gphong_id) {
            $gphong_sql = "AND giaphong $gphong_id '$gphong_sub'";
        } else {
            $gphong_sql = "AND giaphong = '$gphong'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Giá phòng

// Số người ở
if ((isset($_GET['slnguoi'])) && (is_string($_GET['slnguoi']))) { // Form submission.
    $slnguoi = $_GET['slnguoi'];
    $slnguoi_id = strtok($slnguoi, " ");
    $slnguoi_sub = substr($slnguoi, strpos($slnguoi, ' ') + strlen(' '));

    if (empty($slnguoi)) {
        $slnguoi_sql = " ";
    } else {
        if ('=' == $slnguoi_id || '>' == $slnguoi_id || '<' == $slnguoi_id || '>=' == $slnguoi_id || '<=' == $slnguoi_id) {
            $slnguoi_sql = "AND songuoio $slnguoi_id '$slnguoi_sub'";
        } else {
            $slnguoi_sql = "AND songuoio = '$slnguoi'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Số người ở

// Tiền điện
if ((isset($_GET['gdien'])) && (is_string($_GET['gdien']))) { // Form submission.
    $gdien = $_GET['gdien'];
    $gdien_id = strtok($gdien, " ");
    $gdien_sub = substr($gdien, strpos($gdien, ' ') + strlen(' '));

    if (empty($gdien)) {
        $gdien_sql = " ";
    } else {
        if ('=' == $gdien_id || '>' == $gdien_id || '<' == $gdien_id || '>=' == $gdien_id || '<=' == $gdien_id) {
            $gdien_sql = "AND tiendien $gdien_id '$gdien_sub'";
        } else {
            $gdien_sql = "AND tiendien = '$gdien'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Tiền điện

// Tiền nước
if ((isset($_GET['gnuoc'])) && (is_string($_GET['gnuoc']))) { // Form submission.
    $gnuoc = $_GET['gnuoc'];
    $gnuoc_id = strtok($gnuoc, " ");
    $gnuoc_sub = substr($gnuoc, strpos($gnuoc, ' ') + strlen(' '));

    if (empty($gnuoc)) {
        $gnuoc_sql = " ";
    } else {
        if ('=' == $gnuoc_id || '>' == $gnuoc_id || '<' == $gnuoc_id || '>=' == $gnuoc_id || '<=' == $gnuoc_id) {
            $gnuoc_sql = "AND tiennuoc $gnuoc_id '$gnuoc_sub'";
        } else {
            $gnuoc_sql = "AND tiennuoc = '$gnuoc'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Tiền nước

// Giờ giấc
if ((isset($_GET['ggiac'])) && (is_string($_GET['ggiac']))) { // Form submission.
    $ggiac = $_GET['ggiac'];
    $ggiac_id = strtok($ggiac, " ");
    $ggiac_sub = substr($ggiac, strpos($ggiac, ' ') + strlen(' '));

    if (empty($ggiac)) {
        $ggiac_sql = " ";
    } else {
        if ('=' == $ggiac_id || '>' == $ggiac_id || '<' == $ggiac_id || '>=' == $ggiac_id || '<=' == $ggiac_id) {
            $ggiac_sql = "AND giogiac $ggiac_id '$ggiac_sub'";
        } else {
            $ggiac_sql = "AND giogiac LIKE '%$ggiac%'";
        }
    }
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Giờ giấc

// Nhà vệ sinh
if ((isset($_GET['nvs'])) && (is_string($_GET['nvs']))) { // Form submission.
    $nvs = $_GET['nvs'];
} else { // Không có ID hợp lệ, hủy tập lệnh.
    echo '<p class="error">Trang này lỗi không lấy được id người dùng!.</p>';
    include('includes/footer.html');
    exit();
}
// End Nhà vệ sinh

// Nhúng file kết nối với database
include('ketnoi.php');

// Lấy dữ liệu từ file tknangcao.php
if ($xp == null && $lchon == 'trhoc') {
    $sql = "SELECT DISTINCT ON (tr.mant) us.hoten, us.sdt, CONCAT(tr.sonha,' ',d.tenduong,', ',xp.tenpx) as address, tn.tentn, lnt.tenlnt, tr.dientich, tr.songuoio, tr.nhavesinh, tr.giaphong, tr.tiencoc, tr.tiendien, tr.tiennuoc, tr.giogiac, tr.slphongtro,
    ST_X(ST_Centroid(tr.geom)) AS lon, ST_Y(ST_Centroid(tr.geom)) AS lat,
    REPLACE(REPLACE(REPLACE('' || box2d(xp.geom),'BOX(',''),')',''),' ',',') AS bbox2
    FROM public.nhatro tr
        LEFT JOIN public.truong ti ON ST_DWithin(tr.geom::geography, ti.geom::geography, $bkinh)
        INNER JOIN public.user us ON tr.id = us.id
        INNER JOIN public.duong d ON tr.maduong = d.maduong
        INNER JOIN public.tiennghi tn ON tr.matn = tn.matn 
        INNER JOIN public.loainhatro lnt ON tr.malnt = lnt.malnt 
        INNER JOIN public.xaphuong xp ON tr.maphuongxa = xp.mapx
    WHERE ti.matr = '$tentr'
        AND tenduong ILIKE '%$tduong%'
        AND tenlnt ILIKE '%$lphong%'
        $dtich_sql
        $gphong_sql
        $slnguoi_sql
        $gdien_sql
        $gnuoc_sql
        $ggiac_sql
        AND nhavesinh ILIKE '%$nvs%';";

    $query = pg_query($conn, $sql);
    $i = 1;
    $rows = pg_num_rows($query);

    if ($rows > 0) {
        echo '<div class="timkiemnc">
                    <div class="scrollbar2" id="style-2">
                        <div class="force-overflow2" id="kq_tkgian">';
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Có ";
        echo pg_num_rows($query);
        echo " kết quả được tìm thấy</b></p>";

        echo '<table class="table-bordered tbfind" style="width: 99.9%">
                                <tr bgcolor="#eeeeee">
                                    <td style="text-align: center"><b>STT</b></td>
                                    <td style="width: 5%"><b>Chủ trọ</b></td>
                                    <td style="width: 11%"><b>Địa chỉ</b></td>
                                    <td style="width: 10%"><b>Liên hệ</b></td>
                                    <td style="width: 10%"><b>Loại nhà trọ</b></td>
                                    <td style="width: 5%"><b>Diện tích</b></td>
                                    <td style="width: 10%"><b>Tiền cọc, phòng</b></td>
                                    <td style="width: 19%"><b>Giá điện, nước</b></td>
                                    <td style="width: 20%"><b>Thông tin chung</b></td>
                                    <td style="text-align: center"><b>Vị trí</b></td>
                                </tr>';
        $bg = '#eeeeee';
        while ($row2 = pg_fetch_array($query, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
                                    <td class="number_kgian" style="text-align: center"><b>' . $i . '</b></td>
                                    <td>' . $row2['hoten'] . '</td>
                                    <td>' . $row2['address'] . '</td>
                                    <td>' . $row2['sdt'] . '</td>
                                    <td>' . $row2['tenlnt'] . '</td>
                                    <td>' . $row2['dientich'] . 'm2</td>
                                    <td>
                                        <b><i>Tiền cọc:</i></b> ' . number_format($row2['tiencoc'], 0, ',', '.') . 'đ</br>
                                        <b><i>Tiền phòng:</i></b> ' . number_format($row2['giaphong'], 0, ',', '.') . 'đ/tháng
                                    </td>
                                    <td>
                                        <b><i>Giá điện:</i></b> ' . number_format($row2['tiendien'], 0, ',', '.') . '/1 kWh</br>
                                        <b><i>Giá nước:</i></b> ' . number_format($row2['tiennuoc'], 0, ',', '.') . 'đ/m3
                                    </td>
                                    <td>
                                        <b><i>Giờ giấc:</i></b> ' . $row2['giogiac'] . ' </br>
                                        <b><i>Nhà vệ sinh:</i></b> ' . $row2['nhavesinh'] . '</br>
                                        <b><i>Số người ở:</i></b> ' . $row2['songuoio'] . '</br>
                                        <b><i>Tiện nghi:</i></b> ' . $row2['tentn'] . '</br>
                                        <b><i>SL phòng trống:</i></b> ' . $row2['slphongtro'] . '
                                    </td>
                                    <td style="text-align: center">
                                        <button class="zoom" type="button" onclick="addmarker(' . $row2['lon'] . ',' . $row2['lat'] . ');">Zoom</button>
                                        <button class="zoom2" id="zoom2" type="button" onclick="zoom2bbox(' . $row2['bbox2'] . ');">Bbox</button>
                                        <input style="display: none" type="text" id="long_kgian[' . $i . ']" name="long_kgian[' . $i . ']" value="' . $row2['lon'] . '" />
                                        <input style="display: none" type="text" id="lat_kgian[' . $i . ']" name="lat_kgian[' . $i . ']" value="' . $row2['lat'] . '" />
                                    </td>
                                </tr>';
            $i++;
        }
        echo '</table>';
        echo '</div>
            </div>
        </div>';
    } else {
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Không tìm thấy kết quả nào!</b></p>";
    }
} else if ($xp && $lchon == 'trhoc') {
    $sql = "SELECT DISTINCT ON (tr.mant) us.hoten, us.sdt, CONCAT(tr.sonha,' ',d.tenduong,', ',xp.tenpx) as address, tn.tentn, lnt.tenlnt, tr.dientich, tr.songuoio, tr.nhavesinh, tr.giaphong, tr.tiencoc, tr.tiendien, tr.tiennuoc, tr.giogiac, tr.slphongtro,
    ST_X(ST_Centroid(tr.geom)) AS lon, ST_Y(ST_Centroid(tr.geom)) AS lat,
    REPLACE(REPLACE(REPLACE('' || box2d(xp.geom),'BOX(',''),')',''),' ',',') AS bbox2
    FROM public.nhatro tr
        LEFT JOIN public.truong ti ON ST_DWithin(tr.geom::geography, ti.geom::geography, $bkinh)
        INNER JOIN public.user us ON tr.id = us.id
        INNER JOIN public.duong d ON tr.maduong = d.maduong
        INNER JOIN public.tiennghi tn ON tr.matn = tn.matn 
        INNER JOIN public.loainhatro lnt ON tr.malnt = lnt.malnt 
        INNER JOIN public.xaphuong xp ON tr.maphuongxa = xp.mapx
    WHERE tr.maphuongxa = '$xp' AND ti.matr = '$tentr'
        AND tenduong ILIKE '%$tduong%'
        AND tenlnt ILIKE '%$lphong%'
        $dtich_sql
        $gphong_sql
        $slnguoi_sql
        $gdien_sql
        $gnuoc_sql
        $ggiac_sql
        AND nhavesinh ILIKE '%$nvs%';";

    $query = pg_query($conn, $sql);
    $i = 1;
    $rows = pg_num_rows($query);

    if ($rows > 0) {
        echo '<div class="timkiemnc">
                    <div class="scrollbar2" id="style-2">
                        <div class="force-overflow2" id="kq_tkgian">';
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Có ";
        echo pg_num_rows($query);
        echo " kết quả được tìm thấy</b></p>";

        echo '<table class="table-bordered tbfind" style="width: 99.9%">
                                <tr bgcolor="#eeeeee">
                                    <td style="text-align: center"><b>STT</b></td>
                                    <td style="width: 5%"><b>Chủ trọ</b></td>
                                    <td style="width: 11%"><b>Địa chỉ</b></td>
                                    <td style="width: 10%"><b>Liên hệ</b></td>
                                    <td style="width: 10%"><b>Loại nhà trọ</b></td>
                                    <td style="width: 5%"><b>Diện tích</b></td>
                                    <td style="width: 10%"><b>Tiền cọc, phòng</b></td>
                                    <td style="width: 19%"><b>Giá điện, nước</b></td>
                                    <td style="width: 20%"><b>Thông tin chung</b></td>
                                    <td style="text-align: center"><b>Vị trí</b></td>
                                </tr>';
        $bg = '#eeeeee';
        while ($row2 = pg_fetch_array($query, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
                                    <td class="number_kgian" style="text-align: center"><b>' . $i . '</b></td>
                                    <td>' . $row2['hoten'] . '</td>
                                    <td>' . $row2['address'] . '</td>
                                    <td>' . $row2['sdt'] . '</td>
                                    <td>' . $row2['tenlnt'] . '</td>
                                    <td>' . $row2['dientich'] . 'm2</td>
                                    <td>
                                        <b><i>Tiền cọc:</i></b> ' . number_format($row2['tiencoc'], 0, ',', '.') . 'đ</br>
                                        <b><i>Tiền phòng:</i></b> ' . number_format($row2['giaphong'], 0, ',', '.') . 'đ/tháng
                                    </td>
                                    <td>
                                        <b><i>Giá điện:</i></b> ' . number_format($row2['tiendien'], 0, ',', '.') . '/1 kWh</br>
                                        <b><i>Giá nước:</i></b> ' . number_format($row2['tiennuoc'], 0, ',', '.') . 'đ/m3
                                    </td>
                                    <td>
                                        <b><i>Giờ giấc:</i></b> ' . $row2['giogiac'] . ' </br>
                                        <b><i>Nhà vệ sinh:</i></b> ' . $row2['nhavesinh'] . '</br>
                                        <b><i>Số người ở:</i></b> ' . $row2['songuoio'] . '</br>
                                        <b><i>Tiện nghi:</i></b> ' . $row2['tentn'] . '</br>
                                        <b><i>SL phòng trống:</i></b> ' . $row2['slphongtro'] . '
                                    </td>
                                    <td style="text-align: center">
                                        <button class="zoom" type="button" onclick="addmarker(' . $row2['lon'] . ',' . $row2['lat'] . ');">Zoom</button>
                                        <button class="zoom2" id="zoom2" type="button" onclick="zoom2bbox(' . $row2['bbox2'] . ');">Bbox</button>
                                        <input style="display: none" type="text" id="long_kgian[' . $i . ']" name="long_kgian[' . $i . ']" value="' . $row2['lon'] . '" />
                                        <input style="display: none" type="text" id="lat_kgian[' . $i . ']" name="lat_kgian[' . $i . ']" value="' . $row2['lat'] . '" />
                                    </td>
                                </tr>';
            $i++;
        }
        echo '</table>';
        echo '</div>
            </div>
        </div>';
    } else {
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Không tìm thấy kết quả nào!</b></p>";
    }
} else if ($xp && $lchon == 'HST' || $xp && $lchon == 'BOOK' || $xp && $lchon == 'ATM' || $xp && $lchon == 'MARKET' || $xp && $lchon == 'POST' || $xp && $lchon == 'ADM' || $xp && $lchon == 'PARK') {
    $sql = "SELECT DISTINCT ON (tr.mant) us.hoten, us.sdt, CONCAT(tr.sonha,' ',d.tenduong,', ',xp.tenpx) as address, tn.tentn, lnt.tenlnt, tr.dientich, tr.songuoio, tr.nhavesinh, tr.giaphong, tr.tiencoc, tr.tiendien, tr.tiennuoc, tr.giogiac, tr.slphongtro,
    ST_X(ST_Centroid(tr.geom)) AS lon, ST_Y(ST_Centroid(tr.geom)) AS lat,
    REPLACE(REPLACE(REPLACE('' || box2d(xp.geom),'BOX(',''),')',''),' ',',') AS bbox2
    FROM public.nhatro tr
        LEFT JOIN public.tienich ti ON ST_DWithin(tr.geom::geography, ti.geom::geography, $bkinh)
        INNER JOIN public.user us ON tr.id = us.id
        INNER JOIN public.duong d ON tr.maduong = d.maduong
        INNER JOIN public.tiennghi tn ON tr.matn = tn.matn 
        INNER JOIN public.loainhatro lnt ON tr.malnt = lnt.malnt 
        INNER JOIN public.xaphuong xp ON tr.maphuongxa = xp.mapx
    WHERE tr.maphuongxa = '$xp' AND ti.maloaiti = '$lchon'
        AND tenduong ILIKE '%$tduong%'
        AND tenlnt ILIKE '%$lphong%'
        $dtich_sql
        $gphong_sql
        $slnguoi_sql
        $gdien_sql
        $gnuoc_sql
        $ggiac_sql
        AND nhavesinh ILIKE '%$nvs%';";

    $query = pg_query($conn, $sql);
    $i = 1;
    $rows = pg_num_rows($query);

    if ($rows > 0) {
        echo '<div class="timkiemnc">
                    <div class="scrollbar2" id="style-2">
                        <div class="force-overflow2" id="kq_tkgian">';
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Có ";
        echo pg_num_rows($query);
        echo " kết quả được tìm thấy</b></p>";

        echo '<table class="table-bordered tbfind" style="width: 99.9%">
                                <tr bgcolor="#eeeeee">
                                    <td style="text-align: center"><b>STT</b></td>
                                    <td style="width: 5%"><b>Chủ trọ</b></td>
                                    <td style="width: 11%"><b>Địa chỉ</b></td>
                                    <td style="width: 10%"><b>Liên hệ</b></td>
                                    <td style="width: 10%"><b>Loại nhà trọ</b></td>
                                    <td style="width: 5%"><b>Diện tích</b></td>
                                    <td style="width: 10%"><b>Tiền cọc, phòng</b></td>
                                    <td style="width: 19%"><b>Giá điện, nước</b></td>
                                    <td style="width: 20%"><b>Thông tin chung</b></td>
                                    <td style="text-align: center"><b>Vị trí</b></td>
                                </tr>';
        $bg = '#eeeeee';
        while ($row2 = pg_fetch_array($query, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
                                    <td class="number_kgian" style="text-align: center"><b>' . $i . '</b></td>
                                    <td>' . $row2['hoten'] . '</td>
                                    <td>' . $row2['address'] . '</td>
                                    <td>' . $row2['sdt'] . '</td>
                                    <td>' . $row2['tenlnt'] . '</td>
                                    <td>' . $row2['dientich'] . 'm2</td>
                                    <td>
                                        <b><i>Tiền cọc:</i></b> ' . number_format($row2['tiencoc'], 0, ',', '.') . 'đ</br>
                                        <b><i>Tiền phòng:</i></b> ' . number_format($row2['giaphong'], 0, ',', '.') . 'đ/tháng
                                    </td>
                                    <td>
                                        <b><i>Giá điện:</i></b> ' . number_format($row2['tiendien'], 0, ',', '.') . '/1 kWh</br>
                                        <b><i>Giá nước:</i></b> ' . number_format($row2['tiennuoc'], 0, ',', '.') . 'đ/m3
                                    </td>
                                    <td>
                                        <b><i>Giờ giấc:</i></b> ' . $row2['giogiac'] . ' </br>
                                        <b><i>Nhà vệ sinh:</i></b> ' . $row2['nhavesinh'] . '</br>
                                        <b><i>Số người ở:</i></b> ' . $row2['songuoio'] . '</br>
                                        <b><i>Tiện nghi:</i></b> ' . $row2['tentn'] . '</br>
                                        <b><i>SL phòng trống:</i></b> ' . $row2['slphongtro'] . '
                                    </td>
                                    <td style="text-align: center">
                                        <button class="zoom" type="button" onclick="addmarker(' . $row2['lon'] . ',' . $row2['lat'] . ');">Zoom</button>
                                        <button class="zoom2" id="zoom2" type="button" onclick="zoom2bbox(' . $row2['bbox2'] . ');">Bbox</button>
                                        <input style="display: none" type="text" id="long_kgian[' . $i . ']" name="long_kgian[' . $i . ']" value="' . $row2['lon'] . '" />
                                        <input style="display: none" type="text" id="lat_kgian[' . $i . ']" name="lat_kgian[' . $i . ']" value="' . $row2['lat'] . '" />
                                    </td>
                                </tr>';
            $i++;
        }
        echo '</table>';
        echo '</div>
            </div>
        </div>';
    } else {
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Không tìm thấy kết quả nào!</b></p>";
    }
} else {
    $sql = "SELECT DISTINCT ON (tr.mant) us.hoten, us.sdt, CONCAT(tr.sonha,' ',d.tenduong,', ',xp.tenpx) as address, tn.tentn, lnt.tenlnt, tr.dientich, tr.songuoio, tr.nhavesinh, tr.giaphong, tr.tiencoc, tr.tiendien, tr.tiennuoc, tr.giogiac, tr.slphongtro,
    ST_X(ST_Centroid(tr.geom)) AS lon, ST_Y(ST_Centroid(tr.geom)) AS lat,
    REPLACE(REPLACE(REPLACE('' || box2d(xp.geom),'BOX(',''),')',''),' ',',') AS bbox2
    FROM public.nhatro tr
        LEFT JOIN public.tienich ti ON ST_DWithin(tr.geom::geography, ti.geom::geography, $bkinh)
        INNER JOIN public.user us ON tr.id = us.id
        INNER JOIN public.duong d ON tr.maduong = d.maduong
        INNER JOIN public.tiennghi tn ON tr.matn = tn.matn 
        INNER JOIN public.loainhatro lnt ON tr.malnt = lnt.malnt 
        INNER JOIN public.xaphuong xp ON tr.maphuongxa = xp.mapx
    WHERE ti.maloaiti = '$lchon'
        AND tenduong ILIKE '%$tduong%'
        AND tenlnt ILIKE '%$lphong%'
        $dtich_sql
        $gphong_sql
        $slnguoi_sql
        $gdien_sql
        $gnuoc_sql
        $ggiac_sql
        AND nhavesinh ILIKE '%$nvs%';";

    $query = pg_query($conn, $sql);
    $i = 1;
    $rows = pg_num_rows($query);

    if ($rows > 0) {
        echo '<div class="timkiemnc">
                    <div class="scrollbar2" id="style-2">
                        <div class="force-overflow2" id="kq_tkgian">';
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Có ";
        echo pg_num_rows($query);
        echo " kết quả được tìm thấy</b></p>";

        echo '<table class="table-bordered tbfind" style="width: 99.9%">
                                <tr bgcolor="#eeeeee">
                                    <td style="text-align: center"><b>STT</b></td>
                                    <td style="width: 5%"><b>Chủ trọ</b></td>
                                    <td style="width: 11%"><b>Địa chỉ</b></td>
                                    <td style="width: 10%"><b>Liên hệ</b></td>
                                    <td style="width: 10%"><b>Loại nhà trọ</b></td>
                                    <td style="width: 5%"><b>Diện tích</b></td>
                                    <td style="width: 10%"><b>Tiền cọc, phòng</b></td>
                                    <td style="width: 19%"><b>Giá điện, nước</b></td>
                                    <td style="width: 20%"><b>Thông tin chung</b></td>
                                    <td style="text-align: center"><b>Vị trí</b></td>
                                </tr>';
        $bg = '#eeeeee';
        while ($row2 = pg_fetch_array($query, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
                                    <td class="number_kgian" style="text-align: center"><b>' . $i . '</b></td>
                                    <td>' . $row2['hoten'] . '</td>
                                    <td>' . $row2['address'] . '</td>
                                    <td>' . $row2['sdt'] . '</td>
                                    <td>' . $row2['tenlnt'] . '</td>
                                    <td>' . $row2['dientich'] . 'm2</td>
                                    <td>
                                        <b><i>Tiền cọc:</i></b> ' . number_format($row2['tiencoc'], 0, ',', '.') . 'đ</br>
                                        <b><i>Tiền phòng:</i></b> ' . number_format($row2['giaphong'], 0, ',', '.') . 'đ/tháng
                                    </td>
                                    <td>
                                        <b><i>Giá điện:</i></b> ' . number_format($row2['tiendien'], 0, ',', '.') . '/1 kWh</br>
                                        <b><i>Giá nước:</i></b> ' . number_format($row2['tiennuoc'], 0, ',', '.') . 'đ/m3
                                    </td>
                                    <td>
                                        <b><i>Giờ giấc:</i></b> ' . $row2['giogiac'] . ' </br>
                                        <b><i>Nhà vệ sinh:</i></b> ' . $row2['nhavesinh'] . '</br>
                                        <b><i>Số người ở:</i></b> ' . $row2['songuoio'] . '</br>
                                        <b><i>Tiện nghi:</i></b> ' . $row2['tentn'] . '</br>
                                        <b><i>SL phòng trống:</i></b> ' . $row2['slphongtro'] . '
                                    </td>
                                    <td style="text-align: center">
                                        <button class="zoom" type="button" onclick="addmarker(' . $row2['lon'] . ',' . $row2['lat'] . ');">Zoom</button>
                                        <button class="zoom2" id="zoom2" type="button" onclick="zoom2bbox(' . $row2['bbox2'] . ');">Bbox</button>
                                        <input style="display: none" type="text" id="long_kgian[' . $i . ']" name="long_kgian[' . $i . ']" value="' . $row2['lon'] . '" />
                                        <input style="display: none" type="text" id="lat_kgian[' . $i . ']" name="lat_kgian[' . $i . ']" value="' . $row2['lat'] . '" />
                                    </td>
                                </tr>';
            $i++;
        }
        echo '</table>';
        echo '</div>
            </div>
        </div>';
    } else {
        echo "<p style = 'text-align: center; font-size: 13pt; padding:20px 20px 0;'><b>Không tìm thấy kết quả nào!</b></p>";
    }
}
