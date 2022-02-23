<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm nâng cao!</title>
</head>

<body id="tknangcao">
    <?php # Script 3.4 - index.php
    $page_title = 'WebGis thông tin nhà trọ TPNT';
    include('ses2.php');
    include('ketnoi.php');
    global $tenltk;
    if ($tenltk == 'User') {
        include('includes/header_us.php');
    } else if ($tenltk == 'Admin') {
        include('includes/header_ad.php');
    } else {
        include('includes/header.php');
    }
    ?>

    <h1 style="color: green; word-spacing: 2.76px; letter-spacing: 5px; font-weight: bold;">WEBGIS TÌM KIẾM THÔNG TIN NHÀ TRỌ THÀNH PHỐ NHA TRANG</h1></br>

    <div id="fullscreen" class="fullscreen">
        <div id="map" class="maptk"></div>
        <div class="legend">
            <div class="row rowLegend">
                <div class="col-md-12 ChuThich">
                    <label for="chkChuThich" class="chkChuThich">LỚP DỮ LIỆU</label>
                </div>
                <div class="col-md-12">
                    <input type="checkbox" id="chkThanhPho" checked class="check" /><label for="chkThanhPho">TP.Nha
                        Trang</label>
                    <br>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:thanhpho" />
                </div>

                <div class="col-md-12">
                    <input type="checkbox" id="chkXaPhuong" checked class="check" /><label for="chkXaPhuong">Xã
                        Phường</label></br>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:xaphuong" />
                </div>

                <div class="col-md-12">
                    <input type="checkbox" id="chkDuong" checked class="check" /><label for="chkDuong">Đường</label>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:duong" />
                </div>

                <div class="col-md-12">
                    <input type="checkbox" id="chkBus" checked class="check" /><label for="chkBus">Trạm Bus</label>
                    <br>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:trambus" />
                </div>

                <div class="col-md-12">
                    <input type="checkbox" id="chkTienIch" checked class="check" /><label for="chkTienIch">Tiện
                        ích</label>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:tienich" />
                </div>

                <div class="col-md-12">
                    <input type="checkbox" id="chkTruong" checked class="check" /><label for="chkTruong">Trường</label></br>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:truong" />
                </div>

                <div class="col-md-12 colLegend">
                    <input type="checkbox" id="chkNhaTro" checked class="check" /><label for="chkNhaTro">Nhà trọ</label>
                    <img src="http://localhost:8080/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=webgis:nhatro" />
                </div>

                <div class="col-md-12 colLegend">
                    <input id="track" type="checkbox" />
                    <label for="chkViTri">Vị trí của tôi</label>
                </div>
            </div>
        </div>

        <div id="popup" class="ol-popup">
            <a href="#" id="popup-closer" class="ol-popup-closer"></a>

            <div id="popup-content"></div>
        </div>
    </div>

    <input type="hidden" id="info" />

    <table class="table table-borderless table-primary" style="width: 100%;">
        <tr>
            <td style="width: 145px" class="bg-light">
                <!-- Xóa tất cả -->
                <button id="clear-png" onclick="clear_all()" class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i> Xóa tất cả</button>
                <!-- End Xóa tất cả -->
            </td>

            <td class="bg-light">
                <!-- Button tải hình ảnh bản đồ -->
                <a id="export-png" class="btn btn-success btn-block"><i class="fa fa-download"></i> Tải xuống hình ảnh bản đồ PNG</a>
                <a id="image-download" download="map.png"></a>
                <!-- End Button tải hình ảnh bản đồ -->
            </td>

            <!-- Xuất PDF hình ảnh bản đồ -->
            <form class="form">
                <td style="vertical-align: middle; width: 151px">
                    <label for="format"><b>Kích thước trang</b></label>
                </td>
                <td style="padding-left: 0; padding-right: 0">
                    <select id="format" class="form-control">
                        <option value="a0">A0 (chậm)</option>
                        <option value="a1">A1</option>
                        <option value="a2">A2</option>
                        <option value="a3">A3</option>
                        <option value="a4" selected>A4</option>
                        <option value="a5">A5 (nhanh)</option>
                    </select>
                </td>
                <td style="vertical-align: middle; width: 121px">
                    <label for="resolution"><b>Độ phân giải</b></label>
                </td>
                <td style="padding-left: 0; padding-right: 0">
                    <select id="resolution" class="form-control">
                        <option value="72">72 dpi (nhanh)</option>
                        <option value="150">150 dpi</option>
                        <option value="300">300 dpi (chậm)</option>
                    </select>
                </td>
            </form>

            <td style="width: 141px">
                <button id="export-pdf" class="btn btn-warning btn-block"><i class="fa fa-download"></i> Xuất PDF</button>
            </td>
            <!-- End Xuất PDF hình ảnh bản đồ -->
        </tr>
    </table>

    <div class="row">
        <!-- Tìm đường -->
        <div class="col-md-6">
            <div id="Route">
                <div class="timduong" style="font-size: 14pt; padding: 5px; padding-left: 0; color: orange">
                    <input id="chkRoadFind" type="checkbox" />
                    <label for="chkTimDuong"><b>TÌM ĐƯỜNG</b> <i class="fas fa-road"></i></label>
                </div>

                <div class="form-group">
                    <label class="medium mb-1"><b>Tọa độ điểm đi:</b></label>
                    <input class="form-control py-3" id="txtPoint1" name="txtPoint1" type="text" />
                </div>
                <div class="form-group">
                    <label class="medium mb-1"><b>Tọa độ điểm đến:</b></label>
                    <input class="form-control py-3" id="txtPoint2" name="txtPoint2" type="text" />
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button id="btnSolve" class="btn btn-primary btn-block">Tìm đường</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button id="btnReset" class="btn btn-primary btn-block">Xóa đường</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tìm đường -->

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <!-- Pan Zoom -->
                    <div class="pan" style="font-size: 14pt; padding: 5px; padding-left: 0; color: orange">
                        <label for="chkPan"><i class="fas fa-search-plus"></i> <b>ĐI TỚI PHƯỜNG XÃ</b></label>
                    </div>
                    <div class="form-group">
                        <form action="" method="POST">
                            <label class="medium mb-1"><b>Chọn phường xã: &nbsp;</b></label>
                            <select class="form-control" name="pan" id='pan' style="width: 100%">
                                <option value="">-- Chọn nơi đến --</option>
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

                            <script type="text/javascript">
                                $("#pan").change(function() {
                                    $(document).ready(function pan() {
                                        var xaphuong = document.getElementById("pan").value;

                                        if (window.XMLHttpRequest) {
                                            // Code for IE7+, Firefox, Chrome, Opera, Safari 
                                            xmlhttp = new XMLHttpRequest();
                                        } else {
                                            // Code for IE6, IE5
                                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                        }
                                        xmlhttp.onreadystatechange = function() {
                                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                document.getElementById("kq_pan").innerHTML = xmlhttp.responseText;
                                            }
                                        }
                                        xmlhttp.open("GET", "xl_panzoom.php?pan=" + xaphuong, true);
                                        xmlhttp.send();
                                    });
                                });
                            </script>
                        </form>
                    </div>
                    <!-- End Pan Zoom -->
                </div>

                <div class="col-md-3" id="kq_pan">

                </div>
            </div>

            <div class="row" style="margin-top: 12px;">
                <div class="col-md-6">
                    <!-- Đo lường -->
                    <div class="doluong" style="font-size: 14pt; padding: 5px; padding-left: 0; color: orange">
                        <label for="chkTimDuong"><i class="fas fa-ruler-combined"></i> <b>ĐO LƯỜNG</b></label>
                    </div>
                    <div class="form-group">
                        <form id="measure">
                            <label class="medium mb-1"><b>Loại đo lường: &nbsp;</b></label>
                            <select class="form-control" id="measuretype">
                                <option value="select">-- Chọn tùy chọn Đo lường --</option>
                                <option value="length">Chiều dài (LineString)</option>
                                <option value="area">Khu vực (Polygon)</option>
                                <option value="clear">Xóa Đo lường</option>
                            </select>
                        </form>
                    </div>
                    <!-- End Đo lường -->
                </div>

                <div class="col-md-6">
                    <!-- Lấy thông tin khi Click lên bản đồ -->
                    <div class="layttin" style="font-size: 14pt; padding: 5px; padding-left: 0; color: orange">
                        <label for="chkTimDuong"><i class="fas fa-search-location"></i> <b>LẤY THÔNG TIN</b></label>
                    </div>
                    <form id="getinfo">
                        <label class="medium mb-1"><b>Lựa chọn:&nbsp;</b></label>
                        <select class="form-control" id="getinfotype">
                            <option value="select">-- Chọn tùy chọn --</option>
                            <option value="activate_getinfo">Kích hoạt GetFeatureinfo</option>
                            <option value="deactivate_getinfo">Hủy kích hoạt GetFeatureinfo</option>
                        </select>
                    </form>
                    <!-- End Lấy thông tin khi Click lên bản đồ -->
                </div>
            </div>
        </div>
    </div>

    <div class="wrapMainProductTabs">
        <div class="titleMainProductTabs">TÌM KIẾM</div>
        <div class="wrapProductTabs">
            <div class="productTabs">
                <div class="scrollAbleTabs">
                    <button class="tabsLinks tabs active" onclick="openTab(event, 'tab1')">TÌM KIẾM THUỘC TÍNH</button>

                    <button class="tabsLinks tabs" onclick="openTab(event, 'tab2')">TÌM KIẾM KHÔNG GIAN</button>

                    <button class="tabsLinks tabs" onclick="openTab(event, 'tab3')">TÌM KIẾM XUNG QUANH</button>

                    <button class="btn btn-danger" onclick="delete_result()">XÓA KẾT QUẢ</button>
                </div>

                <div id="tab1" class="contentProductTabs">
                    <div class="subProductTabs">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <p style="font-size: 13pt; padding: 0; text-align: justify">Sử dụng các toán tử <font color="red">= (bằng), > (lớn hơn), < (bé hơn), >= (lớn hơn hoặc bằng), <= (bé hơn hoặc bằng)</font>
                                                để thực hiện tìm kiếm với một số thuộc tính, các thuộc tính không muốn xét có thể bỏ trống! <b>Lưu ý:</b> Các toán tử với thuộc tính muốn tìm ngăn cách nhau bởi dấu cách!</p>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Tên đường:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: Nguyễn Đình Chiểu" id="txtTenDuong" name="txtTenDuong" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="medium mb-1" for=""><b>Phường/Xã:</b></label>
                                        <select class="form-control" name="txtPhuongXa" id='txtPhuongXa'>
                                            <option value=""> -- Chọn hoặc bỏ qua -- </option>
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
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Diện tích sử dụng (m2):</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: = 16" id="txtDienTich" name="txtDienTich" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Loại nhà trọ:</b></label>
                                            <select class="form-control" id="txtLPhong" name="txtLPhong">
                                                <option value=""> -- Chọn hoặc bỏ qua -- </option>
                                                <option value="Sinh viên">Sinh viên</option>
                                                <option value="Nguyên căn">Nguyên căn</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Nhà vệ sinh:</b></label>
                                            <select class="form-control" id="txtNVS" name="txtNVS">
                                                <option value=""> -- Chọn hoặc bỏ qua -- </option>
                                                <option value="Riêng">Riêng</option>
                                                <option value="Chung">Chung</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá phòng/tháng:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: <= 1000000" id="txtGPhong" name="txtGPhong" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Số lượng người ở:</b></label>
                                            <input class="form-control py-3" placeholder="Mời nhập một số... hoặc < 4" id="txtSLNguoi" name="txtSLNguoi" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá điện/1kWh:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: < 5000" id="txtGDien" name="txtGDien" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá nước/m3:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: >= 15000" id="txtGNuoc" name="txtGNuoc" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giờ đóng cửa:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: 23h hoặc > 23h" id="txtGioGiac" name="txtGioGiac" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <button type="button" name="submit" onclick="tknangcao();" class="btn btn-success btn-block">Tìm kiếm</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <button type="reset" name="submit" class="btn btn-primary btn-block">Làm mới</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </br>
                        <div class="col-md-12" id="kq_tknangcao">
                            <!-- <div class="timkiemnc">
                                <div class="scrollbar2" id="style-2">
                                    <div class="force-overflow2" id="kq_tknangcao">
                                        Kết quả tìm kiếm
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div id="tab2" class="contentProductTabs">
                    <div class="subProductTabs">
                        <div class="col-md-12">
                            <form action="" method="post" style="margin-top: 20px;">
                                <legend>Tìm kiếm Nhà trọ thuộc Phường/Xã hoặc gần Đối Tượng:</legend>

                                <table class="tables table-borderless">
                                    <tr>
                                        <td class="tkgian" style="width: 7%">
                                            <label class="medium mb-1 motel" for="inputXP"><b>Phường / Xã <i class="fas fa-object-group icon_motel"></i> :
                                                </b></label>
                                        </td>
                                        <td class="tkgian" style="width: 39%">
                                            <select class="form-control" name="xaphuong" id='xaphuong' style="width: 576px">
                                                <option value=""> -- Chọn hoặc bỏ qua -- </option>
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
                                        </td>
                                    </tr>
                                </table>

                                <table class="tables table-borderless">
                                    <tr>
                                        <td class="tkgian" style="width: 13.4%">
                                            <label class="medium mb-1" for=""><b>Đối tượng <i class="far fa-life-ring icon_motel"></i> : </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <select class="form-control" id="txtKG" name="txtKG" style="width: 576px">
                                                <option value="HST">Bệnh viện, trung tâm y tế</option>
                                                <option value="trhoc">Trường học</option>
                                                <option value="BOOK">Nhà sách</option>
                                                <option value="ATM">ATM - Ngân hàng</option>
                                                <option value="MARKET">Chợ</option>
                                                <option value="POST">Bưu điện</option>
                                                <option value="ADM">Hành chính</option>
                                                <option value="PARK">Công viên</option>
                                            </select>
                                        </td>

                                        <td class="tkgian" style="width: 13.4%">
                                            <label class="medium mb-1" for=""><b>Bán kính (m) <i class="fas fa-bullseye icon_motel"></i> : </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <input class="form-control py-3" placeholder="Ví dụ: 500" id="txtBanKinh" name="txtBanKinh" type="number" required />
                                        </td>
                                    </tr>
                                </table>

                                <div id="kq_select">

                                </div>

                                <script type="text/javascript">
                                    $("#txtKG").change(function() {
                                        $(document).ready(function kgian() {
                                            var kgian = document.getElementById("txtKG").value;

                                            if (kgian == 'trhoc') {
                                                if (window.XMLHttpRequest) {
                                                    // Code for IE7+, Firefox, Chrome, Opera, Safari 
                                                    xmlhttp = new XMLHttpRequest();
                                                } else {
                                                    // Code for IE6, IE5
                                                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                                }
                                                xmlhttp.onreadystatechange = function() {
                                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                        document.getElementById("kq_select").innerHTML = xmlhttp.responseText;
                                                    }
                                                }
                                                xmlhttp.open("GET", "xl_select.php?select=" + kgian, true);
                                                xmlhttp.send();
                                            } else {
                                                $("#kq_select").empty();
                                            }
                                        });
                                    });
                                </script>

                                <p style="font-size: 13pt; padding: 0; text-align: justify">Sử dụng các toán tử <font color="red">= (bằng), > (lớn hơn), < (bé hơn), >= (lớn hơn hoặc bằng), <= (bé hơn hoặc bằng)</font>
                                                để thực hiện tìm kiếm với một số thuộc tính, các thuộc tính không muốn xét có thể bỏ trống! <b>Lưu ý:</b> Các toán tử với thuộc tính muốn tìm ngăn cách nhau bởi dấu cách!</p>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Tên đường:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: Nguyễn Đình Chiểu" id="txtTenDuongKG" name="txtTenDuongKG" type="text" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Diện tích sử dụng (m2):</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: = 16" id="txtDienTichKG" name="txtDienTichKG" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Loại nhà trọ:</b></label>
                                            <select class="form-control" id="txtLPhongKG" name="txtLPhongKG">
                                                <option value=""> -- Chọn hoặc bỏ qua -- </option>
                                                <option value="Sinh viên">Sinh viên</option>
                                                <option value="Nguyên căn">Nguyên căn</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Nhà vệ sinh:</b></label>
                                            <select class="form-control" id="txtNVSKG" name="txtNVSKG">
                                                <option value=""> -- Chọn hoặc bỏ qua -- </option>
                                                <option value="Riêng">Riêng</option>
                                                <option value="Chung">Chung</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá phòng/tháng:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: <= 1000000" id="txtGPhongKG" name="txtGPhongKG" type="text" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Số lượng người ở:</b></label>
                                            <input class="form-control py-3" placeholder="Mời nhập một số... hoặc < 4" id="txtSLNguoiKG" name="txtSLNguoiKG" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá điện/1kWh:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: < 5000" id="txtGDienKG" name="txtGDienKG" type="text" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giá nước/m3:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: >= 15000" id="txtGNuocKG" name="txtGNuocKG" type="text" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="medium mb-1" for=""><b>Giờ đóng cửa:</b></label>
                                            <input class="form-control py-3" placeholder="Ví dụ: 23h hoặc > 23h" id="txtGioGiacKG" name="txtGioGiacKG" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group mb-1">
                                            <button id="btkgian" type="button" style="width: 152px" onclick="tkgian();" class="btn btn-success btn-block">Tìm kiếm</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-1">
                                            <button type="reset" name="submit" class="btn btn-primary btn-block">Làm mới</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        </br>
                        <div class="col-md-12" id="kq_tkgian">
                            <!-- <div class="timkiemnc">
                                <div class="scrollbar2" id="style-2">
                                    <div class="force-overflow2" id="kq_tknangcao">
                                        Kết quả tìm kiếm
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div id="tab3" class="contentProductTabs">
                    <div class="subProductTabs">
                        <div class="col-md-12">
                            <form action="" method="post" style="margin-top: 20px;">
                                <table class="tables table-borderless">
                                    <tr>
                                        <td class="tkgian" style="width: 19.7%">
                                            <label class="medium mb-1" for=""><b>Đối tượng cần tìm kiếm <i class="far fa-life-ring icon_motel"></i> : </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <select class="form-control" id="txtXQ" name="txtXQ" style="width: 419px">
                                                <option value="HST">Bệnh viện, trung tâm y tế</option>
                                                <option value="ntro">Nhà trọ</option>
                                                <option value="trhoc">Trường học</option>
                                                <option value="BOOK">Nhà sách</option>
                                                <option value="ATM">ATM - Ngân hàng</option>
                                                <option value="MARKET">Chợ</option>
                                                <option value="POST">Bưu điện</option>
                                                <option value="ADM">Hành chính</option>
                                                <option value="PARK">Công viên</option>
                                            </select>
                                        </td>

                                        <td class="tkgian" style="width: 13.4%">
                                            <label class="medium mb-1" for=""><b>Bán kính (m) <i class="fas fa-bullseye icon_motel"></i> : </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <input class="form-control py-3" placeholder="Ví dụ: 500" id="txtBanKinhXQ" name="txtBanKinhXQ" type="number" required />
                                        </td>
                                    </tr>
                                </table>

                                <table class="tables table-borderless">
                                    <tr>
                                        <td class="tkgian" style="width: 13.4%">
                                            <input id="chkLonLat" type="checkbox" />
                                            <label class="medium mb-1" for=""><b>Chọn tọa độ <i class="fas fa-bullseye icon_motel"></i> : </b></label>
                                        </td>

                                        <td class="tkgian">
                                            <label class="medium mb-1" for=""><b>Lon: </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <input class="form-control py-3" placeholder="Ví dụ: 109.123456" id="txtLon" name="txtLon" type="text" />
                                        </td>

                                        <td class="tkgian">
                                            <label class="medium mb-1" for=""><b>Lat: </b></label>
                                        </td>
                                        <td class="tkgian">
                                            <input class="form-control py-3" placeholder="Ví dụ: 12.123456" id="txtLat" name="txtLat" type="text" />
                                        </td>
                                    </tr>
                                </table>

                                <div id="kq_select_kgian">
                                    <!-- <div class="timkiemnc">
                                        Thêm điều kiện tìm kiếm thuộc tính đối với nhà trọ
                                    </div> -->
                                </div>

                                <script type="text/javascript">
                                    $("#txtXQ").change(function() {
                                        $(document).ready(function selectkgian() {
                                            var select_kgian = document.getElementById("txtXQ").value;

                                            if (select_kgian == 'ntro') {
                                                if (window.XMLHttpRequest) {
                                                    // Code for IE7+, Firefox, Chrome, Opera, Safari 
                                                    xmlhttp = new XMLHttpRequest();
                                                } else {
                                                    // Code for IE6, IE5
                                                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                                }
                                                xmlhttp.onreadystatechange = function() {
                                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                        document.getElementById("kq_select_kgian").innerHTML = xmlhttp.responseText;
                                                    }
                                                }
                                                xmlhttp.open("GET", "xl_select_kgian.php?select=" + select_kgian, true);
                                                xmlhttp.send();
                                            } else {
                                                $("#kq_select_kgian").empty();
                                            }
                                        });
                                    });
                                </script>

                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group mb-1">
                                            <button type="button" id="btxquanh" style="width: 152px" onclick="tkxquanh();" class="btn btn-success btn-block">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        </br>
                        <div class="col-md-12" id="kq_xquanh">
                            <!-- <div class="timkiemnc">
                                        Kết quả tìm kiếm
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/footer.html');
    ?>
    <!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
    <!-- end btn scroll top -->
    <script src="scripts/tknangcao.js"></script>
    <script src="scripts/scrolltop2.js"></script>
</body>

</html>