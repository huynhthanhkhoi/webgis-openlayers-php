<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Đăng nhập!</title>

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <style type="text/css">
    .con {
      border-radius: 5px;
      width: 100%;
      margin: 0 auto;
      margin-top: 20px;
      height: 100%;
    }
  </style>
</head>

<body id="login">
  <?php
  $page_title = 'Đăng nhập!';
  include('xl_dangnhap.php');
  include('includes/header.php');
  ?>
  <?php echo $erors_disable; ?>
  <div class="con bg-transparent">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-dark shadow-lg my-3">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
                <img src="images/gis-1.jpg" alt="logo" style="width:100%; height: 100%">
              </div>
              <div class="col-lg-6">
                <div class="p-4">
                  <div class="text-center">
                    <h1 class="h4 text-danger mb-4 ">ĐĂNG NHẬP!</h1>
                  </div>
                  <form class="user" action="login.php" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="txtUsername" aria-describedby="emailHelp" placeholder="Nhập tên User..." value="<?php if (isset($_POST['txtUsername'])) echo $_POST['txtUsername']; ?>" />
                      <?php echo $erors_user1; ?>
                      <?php echo $erors_user2; ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="txtPassword" placeholder="Mật khẩu..." value="<?php if (isset($_POST['txtPassword'])) echo $_POST['txtPassword']; ?>" />
                      <?php echo $erors_pass1; ?>
                      <?php echo $erors_pass2; ?>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input type="submit" name="dangnhap" class="btn btn-primary btn-user btn-block" style="font-size: 12pt;" value="Đăng nhập" />
                  </form>
                  <hr>
                  <a href="dangki.php" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Đăng ký tài khoản!
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <?php include('includes/footer.html') ?>
  <!-- btn scroll top -->
  <div class="btnScrollTop"><i class="fas fa-angle-up"></i></button></div>
  <!-- end btn scroll top -->
  <script src="scripts/scrolltop2.js"></script>
</body>

</html>