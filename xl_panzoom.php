<?php
if ((isset($_GET['pan'])) && (is_string($_GET['pan']))) { // From index.php, tknangcao.php
    $pan = $_GET['pan'];
}

// Nhúng file kết nối với database
include('ketnoi.php');

// Lấy dữ liệu từ file tknangcao.php, index.php
if ($pan) {
    $sql_lchon = "SELECT REPLACE(REPLACE(REPLACE('' || box2d(xaphuong.geom),'BOX(',''),')',''),' ',',') AS bbox2 
                        FROM public.xaphuong
                        WHERE mapx = '$pan'";
    $query_lchon = pg_query($conn, $sql_lchon);
    $i = 1;
    $rows_lchon = pg_num_rows($query_lchon);

    if ($rows_lchon > 0) {
        while ($row2 = pg_fetch_array($query_lchon, NULL, PGSQL_ASSOC)) {
            echo '<button class="btn btn-success btn-block panzoom" id="panzoom" type="button" onclick="zoomPanbbox(' . $row2['bbox2'] . ');">Đi tới</button>';
        }
    }
} else {
}
