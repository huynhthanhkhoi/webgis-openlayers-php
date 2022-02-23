<?php
//Khai báo sử dụng session
session_start();

$erors_home = "";
$erors_user1 = "";
$erors_user2 = "";
$erors_pass1 = "";
$erors_pass2 = "";
$erors_disable = "";
$isValue = true;

//Xử lý đăng nhập
if (isset($_POST['dangnhap'])) {

    //Kết nối tới database
    include('ketnoi.php');

    //Lấy dữ liệu nhập vào
    $tentk = addslashes($_POST['txtUsername']);
    $pass = addslashes($_POST['txtPassword']);

    // mã hóa pasword
    // $password = $pass;
    // $password = md5($pass);

    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if ($tentk) {
        // Lấy tentk từ database
        $query1 = pg_query($conn, "SELECT tentk FROM public.user WHERE tentk='$tentk'");

        //Kiểm tra tên đăng nhập có tồn tại không
        if (pg_num_rows($query1) == 0) {
            $erors_user2 =  ("<font color='red'>Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại!</font>");
            $isValue = false;
        }
    } else {
        $erors_user1 = ("<font color='red'>Vui lòng nhập đầy đủ tên đăng nhập!</font>");
        $isValue = false;
    }

    if ($pass) {
        // Lấy password từ database
        $query2 = pg_query($conn, "SELECT matkhau, quyentk FROM public.user WHERE matkhau='$pass' AND tentk='$tentk'");
        $row = pg_fetch_array($query2, NULL, PGSQL_NUM);

        //Kiểm tra mật khẩu có tồn tại không
        if (pg_num_rows($query2) == 0) {
            $erors_pass2 =  ("<font color='red'>Mật khẩu không đúng. Vui lòng nhập lại!</font>");
            $isValue = false;
        }
        else if ($row[1] == 'f') {  // Kiểm tra trạng thái hoạt động tài khoản
            $erors_disable = ('<h1>Thông báo quan trọng <i class="fas fa-exclamation-triangle" style="color: orange"></i></h1>
                <p style="font-weight: bold"><font size="4" color="red"> Tài khoản của bạn tạm thời đang bị vô hiệu hóa do vi phạm điều khoản, chính sách hoạt động của chúng tôi. 
                Xin vui lòng liên hệ với quản trị viên để tìm hiểu cách khôi phục tài khoản của bạn !!!</font></p>');
            $isValue = false;
        }
        
    } else {
        $erors_pass1 =  ("<font color='red'>Vui lòng nhập đầy đủ mật khẩu!</font>");
        $isValue = false;
    }

    if ($isValue) {
        //Lưu tên đăng nhập
        $_SESSION['tentk'] = $tentk;
        $_SESSION['time'] = time();
        header("location:index.php");
        die();
    }
}
?>
