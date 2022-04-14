<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=Yii::$app->user->identity->username?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php if (Yii::$app->user->can('indexClient')) :?>
                <li class="nav-item"><a class="nav-link " href="/client"><i class="nav-icon fas fa-circle"></i> <p>Клиенты  </p></a></li>
            <?php endif ?>
            <?php if (Yii::$app->user->can('indexOrder')) :?>
                <li class="nav-item"><a class="nav-link " href="/order"><i class="nav-icon fas fa-circle"></i> <p>Посещения </p></a>
            <?php endif ?>
            <?php if (Yii::$app->user->can('indexUser')) :?>
                <li class="nav-item"><a class="nav-link " href="/user"><i class="nav-icon fas fa-circle"></i> <p>Сотрудники </p></a>
            <?php endif ?>
</li>
</ul>        </nav>
    </div>
    <!-- /.sidebar -->
</aside>