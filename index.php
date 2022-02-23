<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebGis Demo</title>
</head>

<body id="index">
    <?php # Script 3.4 - index.php
    $page_title = 'WebGis demo';
    include('ses2.php');
    global $tenltk;
    if ($tenltk == 'User') {
        include('includes/header_us.php');
    } else if ($tenltk == 'Admin') {
        include('includes/header_ad.php');
    } else {
        include('includes/header.php');
    }
    ?>
    <!-- Map -->
    <div id="fullscreen" class="fullscreen">
        <!-- Form tìm kiếm nhà trọ cơ bản -->
        <div class="find">
            <div class="col-md-12 ChuThich">
                <label for="chkChuThich" class="chkChuThich">TÌM KIẾM</label>
            </div>
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="form-group">
                        <label class="medium mb-1" for="inputAddress"><b>Tìm gì:</b></label>
                        <input class="form-control py-3" id="txtTieuChi" name="txtTieuChi" type="text" />
                    </div>
                    <div class="form-group">
                        <label class="medium mb-1" for="inputAddress"><b>Ở đâu:</b></label>
                        <input class="form-control py-3" id="txtKhuVuc" name="txtKhuVuc" type="text" />
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <button type="button" name="submit" onclick="timkiem();" class="btn btn-primary btn-block">Tìm kiếm</button>
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
            <div class="scrollbar" id="style-1">
                <div class="force-overflow" id="divkq">
                    <!-- Kết quả tìm kiếm -->
                </div>
            </div>
        </div>
        <!-- End Form tìm kiếm nhà trọ cơ bản -->

        <!-- Bản đồ TPNT -->
        <div id="map" class="map"></div>
        <!-- End Bản đồ TPNT -->

        <!-- Chú thích -->
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
        <!-- End Chú thích -->

        <!-- Popup bật lên khi Click -->
        <div id="popup" class="ol-popup">
            <a href="#" id="popup-closer" class="ol-popup-closer"></a>
            <div id="popup-content"></div>
        </div>
        <!-- End Popup bật lên khi Click -->
    </div>
    <!-- End Map -->

    <!-- Chi tiết nhà trọ -->
    <div id="info"></div>
    <!-- End Chi tiết nhà trọ -->

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

    <?php
    include('includes/footer.html');
    ?>
    <!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></div>
    <!-- end btn scroll top -->
    <script src="scripts/scrolltop2.js"></script>
</body>

</html>