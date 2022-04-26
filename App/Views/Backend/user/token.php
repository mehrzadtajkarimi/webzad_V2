<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>پنل مدیریت | صفحه ثبت نام</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/dist/css/bootstrap-rtl.min.css">
  <!-- template rtl version -->
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/dist/css/custom-style.css">
  <link rel="stylesheet" href="<?= asset_url() ?>Backend/plugins/WOW/css/libs/animate.css">
    <!-- jQuery -->
    <script src="<?= asset_url() ?>Backend/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition register-page bg-primary">





  <div class="register-box wow fadeInDown" data-wow-delay="0.5s">
    <a href="<?= base_url() ?>admin/login" class="btn btn-primary mt-4 mb-4">بازگشت</a>
    <div class="register-logo">
      <img src="<?= asset_url() ?>Backend/dist/img/ukfav-icon.png" alt="">

      <b class='text-dark'>کد ارسالی را وارد نمایید</b>

    </div>

    <div class="shadow-lg card ">
      <small>

        <?= \App\Utilities\FlashMessage::show_message() ?>
      </small>
      <div class="card-body register-card-body">
        <p class="login-box-msg text-muted">برای ورود یا ثبت نام کد ارسالی به تلفن همراه خود را وارد نمایید.</p>

        <form id="form-login" action="<?= base_url() ?>admin/token" method="POST">
          <div class="mb-3 input-group ">
            <input type="text" id="token-number" class="form-control " name="token" maxlength="4" placeholder="کد ارسالی 4 رقمی " autofocus autocomplete="off">
            <div class="input-group-append">
              <span class="fa fa-phone input-group-text"></span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>




  <!-- /.register-box -->


  <!-- Bootstrap 4 -->
  <script src="<?= asset_url() ?>Backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- iCheck -->
  <script src="<?= asset_url() ?>Backend/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= asset_url() ?>Backend/plugins/WOW/dist/wow.min.js"></script>


<?php
include BASEPATH . "/App/Views/Backend/user/script.php";
?>
</body>

</html>