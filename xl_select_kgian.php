<?php
if ((isset($_GET['select'])) && (is_string($_GET['select']))) { // From index.php, tknangcao.php
    $select = $_GET['select'];
}

// Nhúng file kết nối với database
include('ketnoi.php');

// Lấy dữ liệu từ file tknangcao.php, index.php
if ($select) {
    echo '<p style="font-size: 13pt; padding: 0; text-align: justify">Sử dụng các toán tử <font color="red">= (bằng), > (lớn hơn), < (bé hơn), >= (lớn hơn hoặc bằng), <= (bé hơn hoặc bằng)</font>
            để thực hiện tìm kiếm với một số thuộc tính, các thuộc tính không muốn xét có thể bỏ trống! <b>Lưu ý:</b> Các toán tử với thuộc tính muốn tìm ngăn cách nhau bởi dấu cách!</p>
            <div class="form-row">
            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Tên đường:</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: Nguyễn Đình Chiểu" id="txtTenDuongXQ" name="txtTenDuongXQ" type="text" />
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Diện tích sử dụng (m2):</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: = 16" id="txtDienTichXQ" name="txtDienTichXQ" type="text" />
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Loại nhà trọ:</b></label>
            <select class="form-control" id="txtLPhongXQ" name="txtLPhongXQ">
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
            <select class="form-control" id="txtNVSXQ" name="txtNVSXQ">
            <option value=""> -- Chọn hoặc bỏ qua -- </option>
            <option value="Riêng">Riêng</option>
            <option value="Chung">Chung</option>
            </select>
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Giá phòng/tháng:</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: <= 1000000" id="txtGPhongXQ" name="txtGPhongXQ" type="text" />
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Số lượng người ở:</b></label>
            <input class="form-control py-3" placeholder="Mời nhập một số... hoặc < 4" id="txtSLNguoiXQ" name="txtSLNguoiXQ" type="text" />
            </div>
            </div>
            </div>

            <div class="form-row">
            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Giá điện/1kWh:</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: < 5000" id="txtGDienXQ" name="txtGDienXQ" type="text" />
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Giá nước/m3:</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: >= 15000" id="txtGNuocXQ" name="txtGNuocXQ" type="text" />
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group">
            <label class="medium mb-1" for=""><b>Giờ đóng cửa:</b></label>
            <input class="form-control py-3" placeholder="Ví dụ: 23h hoặc > 23h" id="txtGioGiacXQ" name="txtGioGiacXQ" type="text" />
            </div>
            </div>
            </div>';
} else {
}
