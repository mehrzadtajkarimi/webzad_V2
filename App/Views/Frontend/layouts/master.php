<!DOCTYPE html>
<html lang="fa-IR" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<head>
    <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/head.php' ?>
</head>

<body dir="rtl" class="woocommerce-active <?= $home_page_active_menu ?? '' ?>  can-uppercase" onmousemove="mover(event)">
    <header id="header-index" class="fixed-top ">
        <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/header.php' ?>
    </header>


    <main id="content" class="site-content">
        <?= $view ?>
    </main>



    <div id="top">
        <i class="fas fa-2x fa-angle-up bg-white text-muted"></i>
    </div>
    <footer id="progress" class="bg-dark p-3 ">
        <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/footer.php' ?>
    </footer>

    <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/footerScript.php' ?>
</body>

</html>
