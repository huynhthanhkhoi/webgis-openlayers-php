<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin nhà trọ!</title>
</head>

<body id="view_motel">
    <?php # Script 10.5 - #5
    // Xem thông tin nhà trọ người dùng
    // Nếu là User chỉ xem được thông tin nhà trọ cá nhân
    // Nếu là Admin sẽ xem được thông tin nhà trọ của tất cả người dùng

    $page_title = 'Xem thông tin nhà trọ!';
    include('session.php');
    global $tenltk;
    if ($tenltk == 'User') {
        include('includes/header_us.php');
    } else if ($tenltk == 'Admin') {
        include('includes/header_ad.php');
    } else {
        include('includes/header.php');
    }
    echo '<h1 style="color: green">Nhà trọ đã đăng ký</h1>';

    include('ketnoi.php');

    // Tìm nạp và in các bản ghi ....
    if ($tenltk == 'User') { // Nếu là User
        echo '<button><a class="form-control bt" style="color: black; border: 2px solid green" href="motel_add.php">Thêm nhà trọ <img src="images/edit_add.png" width="24" height="24"/></a></button>';
        // Số lượng bản ghi sẽ hiển thị trên mỗi trang:
        $display = 3;

        // Xác định xem có bao nhiêu trang ...
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Đã được xác định.
            $pages = $_GET['p'];
        } else { // Cần xác định.
            // Đếm số lượng bản ghi:
            $q2 = "SELECT COUNT(id) FROM public.nhatro WHERE public.nhatro.id ='$maid'";
            $r2 = @pg_query($conn, $q2);
            $row1 = @pg_fetch_array($r2, 0, PGSQL_NUM);
            $records = $row1[0];
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
                $order_by = 'dientich ASC';
                break;
            case 'fn':
                $order_by = 'hoten ASC';
                break;
            case 'ad':
                $order_by = 'songuoio ASC';
                break;
            default:
                $order_by = 'hoten ASC';
                $sort = 'fn';
                break;
        }

        // Xác định truy vấn:
        $q1 = "SELECT mant, hoten, CONCAT(sonha,' ',tenduong,', ',tenpx) as address, tentn, tenlnt, xnhatro, ynhatro, dientich, songuoio, nhavesinh, giaphong, tiencoc, tiendien, tiennuoc, giogiac, slphongtro
    FROM public.nhatro
    INNER JOIN public.user ON public.nhatro.id = public.user.id
    INNER JOIN public.duong ON public.nhatro.maduong = public.duong.maduong
    INNER JOIN public.tiennghi ON public.nhatro.matn = public.tiennghi.matn 
    INNER JOIN public.loainhatro ON public.nhatro.malnt = public.loainhatro.malnt 
    INNER JOIN public.xaphuong ON public.nhatro.maphuongxa = public.xaphuong.mapx
    WHERE public.nhatro.id ='$maid' ORDER BY $order_by LIMIT $display OFFSET $start";
        $r1 = @pg_query($conn, $q1); // Chạy truy vấn.

        // Tiêu đề bảng:
        echo '<table class="table-bordered table-primary tbmotel" align="center" style="width: 800px; margin-top: 20px; margin: 0 auto">
    <tr class="bg-primary">
        <th colspan="4" style="text-align: center; font-size: 25pt; color: white">
        <b>THÔNG TIN CHI TIẾT NHÀ TRỌ</b></th>
    </tr>';
        // Tìm nạp và in tất cả các bản ghi ....
        $bg = '#eeeeee';
        $stt = 0;
        while ($row1 = pg_fetch_array($r1, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
        <td>
            <table style="margin: 10px" width="770" cellpadding="2" cellspacing="10">
                <tr>
                    <td rowspan="18" width="100" style="text-align: center; font-size: 18pt"><b>';
            echo $stt = $stt + 1;
            echo '</b>
                    </td>
                </tr>

                <tr>
                    <td><b>Mã nhà trọ:</b></td>
                    <td>' . $row1['mant'] . '</td>
                </tr>

                <tr>
                    <td><b>Địa chỉ:</b> </td>
                    <td>' . $row1['address'] . '</td>
                </tr>

                <tr>
                    <td><b>Tiện nghi:</b></td>
                    <td>' . $row1['tentn'] . '</td>
                </tr>

                <tr>
                    <td><b>Loại nhà trọ:</b></td>
                    <td>' . $row1['tenlnt'] . '</td>
                </tr>

                <tr>
                    <td><b>Tọa độ X:</b></td>
                    <td>' . $row1['xnhatro'] . '</td>
                </tr>

                <tr>
                    <td><b>Tọa độ Y:</b></td>
                    <td>' . $row1['ynhatro'] . '</td>
                </tr>
                
                <tr>
                    <td><b>Diện tích:</b></td>
                    <td>' . $row1['dientich'] . ' m2</td>
                </tr>

                <tr>
                    <td><b>Số người ở tối đa:</b></td>
                    <td>' . $row1['songuoio'] . '</td>
                </tr>

                <tr>
                    <td><b>Nhà vệ sinh:</b></td>
                    <td>' . $row1['nhavesinh'] . '</td>
                </tr>

                <tr>
                    <td><b>Giá phòng:</b></td>
                    <td>' . number_format($row1['giaphong'], 0, ',', '.') . 'đ / tháng</td>
                </tr>

                <tr>
                    <td><b>Tiền cọc:</b></td>
                    <td>' . number_format($row1['tiencoc'], 0, ',', '.') . 'đ</td>
                </tr>

                <tr>
                    <td><b>Tiền điện:</b></td>
                    <td>' . number_format($row1['tiendien'], 0, ',', '.') . 'đ / 1 kWh</td>
                </tr>

                <tr>
                    <td><b>Tiền nước:</b></td>
                    <td>' . number_format($row1['tiennuoc'], 0, ',', '.') . 'đ / m3</td>
                </tr>

                <tr>
                    <td><b>Giờ giấc:</b></td>
                    <td>' . $row1['giogiac'] . '</td>
                </tr>

                <tr>
                    <td><b>Số lượng phòng trống:</b></td>
                    <td>' . $row1['slphongtro'] . '</td>
                </tr>

                <tr>
                    <td colspan="2"> <b style="margin-right: 260px">Chức năng:</b>
                        <button><a href="motel_edit.php?id=' . $row1['mant'] . '" class="form-control bt" style="color: black; border: 2px solid green">
                            Chỉnh sửa <img src="images/edit.png" width="22" height="24"/>
                        </a></button>
                        <button style="margin-left: 5px"><a href="motel_delete.php?id=' . $row1['mant'] . '" class="form-control bt" style="color: black; border: 2px solid green">
                            Xóa nhà trọ <img src="images/delete.png" width="22" height="22"/>
                        </a></button>
                    </td>
                </tr>
            </table>
        </td> 
		</tr>';
        } // Kết thúc vòng lặp WHILE.
        echo '</table>';

        pg_free_result($r1);
        // pg_close($conn);

        // Tạo các liên kết đến các trang khác, nếu cần.
        if ($pages > 1) {

            echo '<div style="width: 100%; text-align: center; margin-top: 15px"><b>';
            $current_page = ($start / $display) + 1;

            // Nếu đó không phải là trang đầu tiên, hãy tạo nút Previous:
            if ($current_page != 1) {
                echo '<a class="angle-left" href="view_motel.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-left"></i></a> ';
            }

            // Tạo tất cả các trang được đánh số:
            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $current_page) {
                    echo '<a class="linkPaggingList" href="view_motel.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo '<a class="linkPaggingList active">' . $i . '</a>';
                }
            } // Kết thúc vòng lặp FOR.

            // Nếu đó không phải là trang cuối cùng, hãy tạo nút Next:
            if ($current_page != $pages) {
                echo '<a class="angle-right" href="view_motel.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-right"></i></a>';
            }

            echo '</b></div>'; // Đóng đoạn.

        } // Phần cuối của liên kết.

    }

    // CHI TIẾT NHÀ TRỌ ADMIN

    else { // Ngược lại nếu là Admin

        // Số lượng bản ghi sẽ hiển thị trên mỗi trang:
        $display = 3;

        // Xác định xem có bao nhiêu trang ...
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Đã được xác định.
            $pages = $_GET['p'];
        } else { // Cần xác định.
            // Đếm số lượng bản ghi:
            $q2 = "SELECT COUNT(mant) FROM public.nhatro";
            $r2 = @pg_query($conn, $q2);
            $row1 = @pg_fetch_array($r2, 0, PGSQL_NUM);
            $records = $row1[0];
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
                $order_by = 'dientich ASC';
                break;
            case 'fn':
                $order_by = 'hoten ASC';
                break;
            case 'ad':
                $order_by = 'songuoio ASC';
                break;
            default:
                $order_by = 'hoten ASC';
                $sort = 'fn';
                break;
        }

        // Xác định truy vấn:
        $q1 = "SELECT mant, hoten, CONCAT(sonha,' ',tenduong,', ',tenpx) as address, tentn, tenlnt, xnhatro, ynhatro, dientich, songuoio, nhavesinh, giaphong, tiencoc, tiendien, tiennuoc, giogiac, slphongtro
    FROM public.nhatro
    INNER JOIN public.user ON public.nhatro.id = public.user.id
    INNER JOIN public.duong ON public.nhatro.maduong = public.duong.maduong
    INNER JOIN public.tiennghi ON public.nhatro.matn = public.tiennghi.matn 
    INNER JOIN public.loainhatro ON public.nhatro.malnt = public.loainhatro.malnt 
    INNER JOIN public.xaphuong ON public.nhatro.maphuongxa = public.xaphuong.mapx
    ORDER BY $order_by LIMIT $display OFFSET $start";
        $r1 = @pg_query($conn, $q1); // Chạy truy vấn.

        // Tiêu đề bảng:
        echo '<table class="table-bordered table-primary tbmotel" align="center" style="width: 800px; margin-top: 20px; margin: 0 auto">
    <tr class="bg-primary">
        <th colspan="4" style="text-align: center; font-size: 25pt; color: white">
        <b>THÔNG TIN CHI TIẾT NHÀ TRỌ</b></th>
    </tr>';
        // Tìm nạp và in tất cả các bản ghi ....
        $bg = '#eeeeee';
        $stt = 0;

        while ($row1 = pg_fetch_array($r1, NULL, PGSQL_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
        <td>
            <table style="margin: 10px" width="770" cellpadding="2" cellspacing="10">
                <tr>
                    <td rowspan="18" width="100" style="text-align: center; font-size: 18pt"><b>';
            echo $stt = $stt + 1;
            echo '</b>
                    </td>
                </tr>

                <tr>
                    <td><b>Mã NT:</b></td>
                    <td>' . $row1['mant'] . '</td>
                </tr>

                <tr>
                    <td><b>Họ và tên Chủ trọ:</b> </td>
                    <td>' . $row1['hoten'] . '</td>
                </tr>

                <tr>
                    <td><b>Địa chỉ:</b> </td>
                    <td>' . $row1['address'] . '</td>
                </tr>

                <tr>
                    <td><b>Tiện nghi:</b></td>
                    <td>' . $row1['tentn'] . '</td>
                </tr>

                <tr>
                    <td><b>Loại nhà trọ:</b></td>
                    <td>' . $row1['tenlnt'] . '</td>
                </tr>

                <tr>
                    <td><b>Tọa độ X:</b></td>
                    <td>' . $row1['xnhatro'] . '</td>
                </tr>

                <tr>
                    <td><b>Tọa độ Y:</b></td>
                    <td>' . $row1['ynhatro'] . '</td>
                </tr>
                
                <tr>
                    <td><b>Diện tích:</b></td>
                    <td>' . $row1['dientich'] . ' m2</td>
                </tr>

                <tr>
                    <td><b>Số người ở tối đa:</b></td>
                    <td>' . $row1['songuoio'] . '</td>
                </tr>

                <tr>
                    <td><b>Nhà vệ sinh:</b></td>
                    <td>' . $row1['nhavesinh'] . '</td>
                </tr>

                <tr>
                    <td><b>Giá phòng:</b></td>
                    <td>' . number_format($row1['giaphong'], 0, ',', '.') . 'đ / tháng</td>
                </tr>

                <tr>
                    <td><b>Tiền cọc:</b></td>
                    <td>' . number_format($row1['tiencoc'], 0, ',', '.') . 'đ</td>
                </tr>

                <tr>
                    <td><b>Tiền điện:</b></td>
                    <td>' . number_format($row1['tiendien'], 0, ',', '.') . 'đ / 1 kWh</td>
                </tr>

                <tr>
                    <td><b>Tiền nước:</b></td>
                    <td>' . number_format($row1['tiennuoc'], 0, ',', '.') . 'đ / m3</td>
                </tr>

                <tr>
                    <td><b>Giờ giấc:</b></td>
                    <td>' . $row1['giogiac'] . '</td>
                </tr>

                <tr>
                    <td><b>Số lượng phòng trống:</b></td>
                    <td>' . $row1['slphongtro'] . '</td>
                </tr>

                <tr>
                    <td colspan="2"><b style="margin-right: 260px">Chức năng:</b>
                        <button><a href="motel_edit.php?id=' . $row1['mant'] . '" class="form-control bt" style="color: black; border: 2px solid green">
                            Chỉnh sửa <img src="images/edit.png" width="22" height="24"/>
                        </a></button>
                        <button style="margin-left: 5px"><a href="motel_delete.php?id=' . $row1['mant'] . '" class="form-control bt" style="color: black; border: 2px solid green">
                            Xóa nhà trọ <img src="images/delete.png" width="22" height="22"/>
                        </a></button>
                    </td>
                </tr>
            </table>
        </td> 
		</tr>';
        } // Kết thúc vòng lặp WHILE.
        echo '</table>';

        pg_free_result($r1);
        // pg_close($conn);

        // Tạo các liên kết đến các trang khác, nếu cần.
        if ($pages > 1) {

            echo '<div style="width: 100%; text-align: center; margin-top: 15px"><b>';
            $current_page = ($start / $display) + 1;

            // Nếu đó không phải là trang đầu tiên, hãy tạo nút Previous:
            if ($current_page != 1) {
                echo '<a class="angle-left" href="view_motel.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-left"></i></a> ';
            }

            // Tạo tất cả các trang được đánh số:
            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $current_page) {
                    echo '<a class="linkPaggingList" href="view_motel.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo '<a class="linkPaggingList active">' . $i . '</a>';
                }
            } // Kết thúc vòng lặp FOR.

            // Nếu đó không phải là trang cuối cùng, hãy tạo nút Next:
            if ($current_page != $pages) {
                echo '<a class="angle-right" href="view_motel.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '"><i class="fas fa-angle-right"></i></a>';
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