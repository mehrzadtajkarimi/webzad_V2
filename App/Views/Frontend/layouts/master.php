<!DOCTYPE html>
<html lang="fa-IR" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<head>
    <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/head.php' ?>
</head>

<body dir="rtl" class="woocommerce-active <?= $home_page_active_menu ?? '' ?>  can-uppercase" onmousemove="mover(event)">
    <header id="masthead" class="site-header header-v1" style="background-image: none; ">
        <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/header.php' ?>
    </header>


        <div id="content" class="site-content">
            <?= $view ?>
        </div>




        <footer class="site-footer footer-v1">
            <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/footer.php' ?>
        </footer>
    </div>
    <?php include_once BASEPATH  . 'App/Views/Frontend/layouts/includes/footerScript.php' ?>
</body>
</html>