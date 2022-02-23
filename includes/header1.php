<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="includes/styheader.css" type="text/css" media="screen" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Bootstrap-->
    <script src="scripts/jquery-3.4.0.min.js"></script>
    <link rel="stylesheet" href="bootstrap-4.5.3/css/bootstrap.min.css">
    <script src="bootstrap-4.5.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="scripts/jquery-3.4.1.min.js"></script>

    <!-- Custom fonts for this template -->
    <link href="fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">
    <script src="fontawesome-free-5.15.3-web/js/all.js"></script>
    <!--********************************-->

    <!--*****************  CSS *****************************-->
    <link rel="stylesheet" type="text/css" href="css/edit2.css">
    <!--****************************************************-->

    <!-- Custom styles for this template -->
    <script src="v6.5.0-dist/ol.js"></script>
    <link rel="stylesheet" href="v6.5.0-dist/ol.css">
    <script src="vendor/jquery-3.6.0.min.js"></script>
    <script src="scripts/map2.js"></script>

    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script
        src="https://cdn.polyfill.io/v3/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL,TextDecoder">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
</head>

<body>
    <div id="main">
        <div class="wrapHeaderMain">
            <!-- Vùng menu -->
            <nav class="navbar navbar-expand-sm lighten-3 d-flex" id="parent">
                <div class="navbar-toggler text-center w-100 border-0 p-0">
                    <!-- Nút bấm 1 bên trái (float-left) đại diện cho menu 1 -->
                    <button class="navbar-toggler float-left" data-toggle="collapse" data-target="#collapsibleNavbar_1">
                        <span class="navbar-toggler-icon span"></span>
                    </button>

                    <!-- Tiêu đề của vùng-->
                    <a class="navbar-brand" href="#">
                        <!-- <img src="images/infotechntu.png" alt="logo" style="margin-left: 8px; width:40px;"> -->
                        <i style="width: 60px; height: 60px; color: green" class="fab fa-php"></i>
                        <span class="span" style="font-size: 11pt; color: black; font-weight: bold;">PHP WEBSITE</span>
                    </a>
                    <!-- Nút bấm 2 bên phải (float-right) đại diện cho menu 2 -->
                    <button class="navbar-toggler float-right" data-toggle="collapse"
                        data-target="#collapsibleNavbar_2">
                        <span class="navbar-toggler-icon span"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="collapsibleNavbar_1" data-parent="#parent">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo.png" alt="logo" style="width:40px;">
                        <!-- <i style="width: 80px; height: 60px; color: green" class="fab fa-php"></i> -->
                    </a>
                    <nav class="nav navbar-fixed-top navbar-nav hidden-md-down address-head">

                    </nav>
                </div>
                <!--  
                <div class="collapse navbar-collapse">
                    <a href="index.php" class="btn btn-primary trangchu">TRANG CHỦ</a>
                    <a href="tknangcao.php" class="btn btn-primary tknangcao">TÌM KIẾM NÂNG CAO</a>
                    <a href="dangki.php" class="btn btn-primary dangki">ĐĂNG KÝ</a>
                    <a href="login.php" class="btn btn-primary login">ĐĂNG NHẬP</a>
                    <a href="contact.php" class="btn btn-primary lienhe">LIÊN HỆ</a>
                </div>
                -->
                <!-- Menu 2 -->
                <div class="collapse navbar-collapse justify-content-end text-right" id="collapsibleNavbar_2"
                    data-parent="#parent">
                    <ul class="navbar-nav">
                        <?php
						if (isset($_SESSION['tentk']) && $_SESSION['tentk']) {
							$timeLimit = 8000;

							$start = $_SESSION['time'];
							// echo '<a href="logout.php">Logout</a>';
							if (time() - $start > $timeLimit) {
								session_destroy();

								echo '<script language="javascript">';
								echo 'alert("Phiên làm việc của bạn đã hết hạn!")';
								echo '</script>';

								echo '<script>
						window.location.replace("login.php");
						</script>';
							}
							echo '
					<!-- Nav Item - User Information -->
					<li class="nav-item dropdown no-arrow">
					<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="mr-0 d-none d-lg-inline text-dark font-italic span" style="font-size: 13pt">';
							echo $tentk, ' (' . $tenltk . ')';
							echo '
					</span>
					<img class="img-profile rounded-circle" style="object-fit: cover;" src="images/' . $avatar . '" width="40px" height="40px">
					</a>
					<!-- Dropdown - User Information -->
					<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
					<a class="dropdown-item" href="view_users3.php">
					<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
					Hồ sơ
					</a>
					<a class="dropdown-item" href="#">
					<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
					Tùy chỉnh
					</a>
					<a class="dropdown-item" href="#">
					<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
					Hoạt động
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="logout.php">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Đăng xuất
					</a>
					</div>
					</li>';
						} else {
							echo "
					<li class='nav-item'>
						<a class='nav-link' href='login.php'>
							<span class='fas fa-sign-in-alt mr-1'></span>
							Đăng nhập 
						</a>
					</li>";
						}
						?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div id="content">
        <!-- Start of the page-specific content. -->
        <!-- Script 9.1 - header.html -->