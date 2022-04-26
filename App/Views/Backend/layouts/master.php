<!DOCTYPE html>
<html>

<head>

  <?php include_once BASEPATH  . 'App/Views/Backend/layouts/include/head.php' ?>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

      <?php include_once BASEPATH  . 'App/Views/Backend/layouts/include/nav.php' ?>

    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="<?= base_url() ?>admin/dashboard" class="brand-link">
        <img src="<?= asset_url() ?>Backend/dist/img/ukfav-icon.png" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
      </a>
      <div class="sidebar">
        <?php include_once BASEPATH  . 'App/Views/Backend/layouts/include/sidebar.php' ?>
      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <?php include_once BASEPATH  . 'App/Views/Backend/layouts/include/breadcrumb.php' ?>
          </div>
        </div>
      </section>
      <section class="content">
        <?= App\Utilities\FlashMessage::show_message(); ?>
        <?= $view ?>

      </section>
    </div>
    <?php include_once BASEPATH  . 'App/Views/Backend/layouts/include/footer.php' ?>
	<link rel="stylesheet" href="<?= base_url() ?>Assets/Backend/dist/css/meftahstyles.css">
</body>

</html>