<!-- Sidebar user panel (optional) -->
<div class="pb-3 mt-3 mb-3 user-panel d-flex">
    <a href="<?= base_url() ?>admin/profile" class="image">
        <img src="<?= asset_url() ?>Backend/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
        <span class=""><?= admin_name('first_name') . ' ' .  admin_name('last_name')  ?></span>
    </a>
    <div class="info">
        <a href="<?= base_url() ?>admin/logout" class="position-absolute " style="right: 195px">
            <i class="p-1 fa fa-sign-out"></i>
        </a>
    </div>
</div>



<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?= is_active('/admin/users') ?> ">
                <p>
                    کاربران
                    <i class="right fa fa-angle-left"></i>
                </p>
                <i class="nav-icon fa fa-tachometer"></i>
            </a>
            <ul class="nav nav-treeview <?= is_active('/admin/users') ?>">
                <li class="nav-item">
                    <a href="<?= base_url() ?>admin/users" class="nav-link  <?= is_active('/admin/users') ?>">
                        <p>لیست کاربران</p>
                        <i class="fa fa-circle-o nav-icon"></i>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->