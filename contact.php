<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ!</title>
</head>

<body id="lienhe">
    <?php
    $page_title = 'Liên hệ!';
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
    <!-- contact banner -->
    <div class="wrapContactBanner">
        <div class="contentContactBanner">
            <img class="imgContactBanner" src="images/RE1B1CO_1920x1080.jpg" />
            <div class="wrapSubContactBanner">
                <div class="subContactBanner">
                    <h2 class="titleContactBanner">
                        <a href="">LIÊN HỆ VỚI CHÚNG TÔI</a>
                    </h2>
                    <div class="excerptContactBanner">WebGIS tìm kiếm nhà trọ xung quanh khu vực Đại học Nha Trang bằng cách ứng dụng kết hợp công nghệ thông tin và những kiến thức về GIS.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact banner -->

    <div class="wrapInfo">
        <div class="contentInfo">
            <h2 class="titleInfo">GIỚI THIỆU</h2>
            <div class="excerptInfo">
                <p class="excerptInfo">Nha Trang là một thành phố ven biển và là trung tâm kinh tế, chính trị, giáo dục, văn hóa, khoa học kỹ thuật và du lịch của tỉnh Khánh Hòa, Việt Nam. Theo số liệu thống kê của Tổng cục Thống kê, tính đến năm 2018, thành phố này đã có đến 25 trường Đại học, Cao đẳng và Cơ sở nghiên cứu khoa học; thu hút hơn 15.980 sinh viên đến từ khắp các tỉnh thành.</p>
                <p class="excerptInfo">Và một trong những khó khăn lớn nhất của sinh viên khi xa nhà là việc đi thuê trọ. Các bạn sinh viên thường phải vất vả tìm kiếm khắp nơi vì không xác định được một khu vực cụ thể, mất nhiều thời gian, công sức mới có thể tìm được một nơi trọ phù hợp với túi tiền, đáp ứng được nhu cầu. Tuy số lượng sinh viên ngày càng tăng, nhu cầu tìm kiếm nơi trọ ngày càng cao, nhưng cách thức tìm nhà trọ vẫn chưa được cải tiến. Các bạn chỉ có thể tiếp cận thông tin thông qua người quen giới thiệu, bảng tin rao vặt, mạng xã hội…, vất vả tìm đường đến địa chỉ đã được cung cấp để xem tình trạng nơi ở.</p>
                <p class="excerptInfo">Ngày nay, hệ thống thông tin địa lý (GIS) đã phát triển công nghệ cho phép chia sẻ thông tin qua Internet bằng cách tích hợp GIS trên nền Web, tạo thành WebGIS, cho phép cung cấp thông tin trên cơ sở tích hợp các thông tin không gian và thuộc tính của đối tượng đã trở thành hướng đi mới mang lại hiệu quả cao trong nhiều lĩnh vực của đời sống xã hội; cung cấp thông tin, hỗ trợ tìm kiếm nhà trọ cũng là một trong số những lĩnh vực ấy. WebGIS với những ưu điểm nổi bật như hiển thị trực quan, dễ tiếp cận, thông tin truyền tải giàu hình ảnh, cho cái nhìn hệ thống tổng thể và toàn diện có thể hỗ trợ việc cung cấp thông tin phòng trọ được tiến hành nhanh hơn, kết quả tốt hơn, từ đó có thể dễ dàng đưa ra quyết định một cách hiệu quả hơn.</p>
            </div>
        </div>
    </div>

    <!-- page contact -->
    <div class="wrapPageContact">
        <div class="containerPageContact">
            <div class="contentPageContact">
                <div class="row rowInfoStore">
                    <div class="col-sm-6 col-lg-3 colInfoStore">
                        <div class="contentInfoStore">
                            <h2 class="wrapTitleType1 titleItemContact">Địa chỉ</h2>

                            <div class="media mediaInfoStore">
                                <div class="media-left">
                                    <div class="wrapIconItemContact">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="wrapTextItemContact">
                                        <p>Số 02 Nguyễn Đình Chiểu, P. Vĩnh Thọ, TP. Nha Trang, T. Khánh Hòa</p>

                                        <p><a href="https://goo.gl/maps/JXw8WEXzhVHJafji8" title="#" target="_blank">View the map</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 colInfoStore">
                        <div class="contentInfoStore">
                            <h2 class="wrapTitleType1 titleItemContact">Số điện thoại</h2>

                            <div class="media mediaInfoStore">
                                <div class="media-left">
                                    <div class="wrapIconItemContact">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="wrapTextItemContact">
                                        <p><a href="tel:0397 646 695" title="0397 646 695">0397 646 695 (Hai-Sáu 8am
                                                -
                                                5pm)</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 colInfoStore">
                        <div class="contentInfoStore">
                            <h2 class="wrapTitleType1 titleItemContact">Email</h2>

                            <div class="media mediaInfoStore">
                                <div class="media-left">
                                    <div class="wrapIconItemContact">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="wrapTextItemContact">
                                        <p><a href="mailto:loc.dq.59cntt@ntu.edu.vn" title="loc.dq.59cntt@ntu.edu.vn">loc.dq.59cntt@ntu.edu.vn</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 colInfoStore">
                        <div class="contentInfoStore">
                            <h2 class="wrapTitleType1 titleItemContact">Giờ hoạt động</h2>

                            <div class="media mediaInfoStore">
                                <div class="media-left">
                                    <div class="wrapIconItemContact">
                                        <i class="far fa-clock"></i>
                                    </div>
                                </div>

                                <div class="media-body">
                                    <div class="wrapTextItemContact">
                                        <p>Thứ hai-Thứ bảy: 9:30 - 22:00</p>
                                        <p>Chủ nhật: 11:30 - 18:00</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrapFrmAndMap">
                    <div class="row rowFrmAndMapContact">
                        <div class="col-sm-5 colFrmContact">
                            <div class="contentFrmContact">
                                <div class="frmSendMessage">
                                    <h2 class="wrapTitleType1 titleItemContact">Gửi tin nhắn</h2>

                                    <h3 class="textSendMessage"><b>Xin chào!</b>
                                        Nếu bạn có bất kỳ câu hỏi hoặc phản hồi nào cho chúng tôi, vui lòng liên hệ với chúng tôi qua điện thoại, email hoặc bằng biểu mẫu liên hệ bên dưới.</h3>

                                    <div class="form-group">
                                        <label class="titleInputSendMessage">Họ và tên</label>
                                        <input type="text" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label class="titleInputSendMessage">Email</label>
                                        <input type="mail" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label class="titleInputSendMessage">Thể loại</label>
                                        <select class="optionToolbar form-control">
                                            <option class="selectedValue" value="#" selected="selected">Thông tin chung</option>
                                            <option class="selectedValue" value="#">Thông tin nhà trọ</option>
                                            <option class="selectedValue" value="#">Tài khoản của tôi</option>
                                            <option class="selectedValue" value="#">Khác</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="titleInputSendMessage">Số điện thoại</label>
                                        <input type="number" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label class="titleInputSendMessage">Tin nhắn</label>
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>

                                    <button type="button" class="btnType1 btnSendFrm"><i class="far fa-paper-plane"></i>
                                        Gửi ngay</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7 colMapContact">
                            <!-- <div id="map2"></div> -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3898.70622452401!2d109.2001872!3d12.2681489!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067ed3a052f11%3A0xd464ee0a6e53e8b7!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBOaGEgVHJhbmc!5e0!3m2!1svi!2s!4v1623327938861!5m2!1svi!2s" width="705" height="774" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page contact -->
    <?php include('includes/footer.html'); ?>
    <!-- btn scroll top -->
    <div class="btnScrollTop"><i class="fas fa-angle-up"></i></div>
    <!-- end btn scroll top -->
    <script src="scripts/scrolltop2.js"></script>
</body>

</html>