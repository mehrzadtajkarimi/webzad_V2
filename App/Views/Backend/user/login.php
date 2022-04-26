<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>پنل مدیریت | صفحه ورود</title>
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
  <script src="<?= asset_url() ?>Backend/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition register-page bg-primary">





<div class="register-box wow fadeInDown" data-wow-delay="0.5s">
	<div class="register-logo">
		<img src="<?= asset_url() ?>Backend/dist/img/ukfav-icon.png" alt="">

		<b class='text-dark'>ورود به پنل</b>
	</div>

	<small><?= \App\Utilities\FlashMessage::show_message() ?></small>

	<div id="login_loading" style="display: none; text-align: center; margin-bottom: 10px;">در حال پردازش، لطفاً شکیبا باشید...</div>
	<div id="login" class="shadow-lg card">
		<div class="card-body register-card-body">
			<p class="login-box-msg text-muted">برای ورود یا ثبت نام کافیست شماره موبایل خود را وارد کنید.</p>
			<form id="form-login" action="javascript:adminlogin()" data-action_url="<?= base_url() ?>admin/login">
				<div class="mb-3 input-group ">
					<input type="text" id="phone-number" class="form-control " name="phone" maxlength="11" placeholder="شماره تلفن همراه خود را وارد نمایید" autocomplete="off" required>
					<div class="input-group-append"><span class="fa fa-phone input-group-text"></span></div>
				</div>
				<input class="btn btn-primary btn-block" type="submit" value="دریافت رمز یکبارمصرف">
			</form>
			<a href="<?= base_url() ?>admin/login" class="text-center"></a>
		</div>
		<!-- /.form-box -->
	</div>
	<div id="token" class="shadow-lg card" style="display: none;">
		<small><?= \App\Utilities\FlashMessage::show_message() ?></small>
		<div class="card-body register-card-body">
			<p class="login-box-msg text-muted">رمز یکبارمصرف چهار رقمی دریافتی از طریق پیامک را وارد کنید.</p>
			<form id="form-token" action="<?= base_url() ?>admin/token" method="POST" onsubmit="$('#tokenform_loginbtn').val('در حال ورود...');">
				<div class="mb-3 input-group ">
					<input type="text" id="token-number" class="form-control " name="token" maxlength="4" placeholder="کد ارسالی 4 رقمی "  autocomplete="off">
					<div class="input-group-append"><span class="fa fa-lock input-group-text"></span></div>
				</div>
				<input class="btn btn-primary btn-block" type="submit" value="ورود" id="tokenform_loginbtn">
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