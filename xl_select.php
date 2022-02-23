<?php
if ((isset($_GET['select'])) && (is_string($_GET['select']))) { // From index.php, tknangcao.php
    $select = $_GET['select'];
}

// Nhúng file kết nối với database
include('ketnoi.php');

// Lấy dữ liệu từ file tknangcao.php, index.php
if ($select) {
    $sql_lchon = "SELECT * FROM public.truong";
    $query_lchon = pg_query($conn, $sql_lchon);
    $rows_lchon = pg_num_rows($query_lchon);

    if ($rows_lchon > 0) {
        echo '<table class="tables table-borderless">
        <tr>
            <td class="tkgian" style="width: 13.4%">
                <label class="medium mb-1" for=""><b>Chọn trường <i class="fas fa-graduation-cap icon_motel"></i>: </b></label>
            </td>
            <td>
                <select class="form-control" id="txtTR" name="txtTR" style="width: 576px">';
                while ($row2 = pg_fetch_array($query_lchon, NULL, PGSQL_ASSOC)) {
                    echo '<option value="'. $row2['matr'] .'">' . $row2['tentr'] . '</option>';
                }
                echo '</select>
            </td>
        </tr>
        </table>';
    }
} else {
}
?>
