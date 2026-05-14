<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></title>

    <link rel="icon" href="/whey_web/public/assets/admin/assets/images/icon/logo.png">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/metismenujs.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/styles.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/responsive.css">
</head>
<body>
<div id="preloader">
    <div class="loader"></div>
</div>

<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="/whey_web/admin">
                    <img src="/whey_web/public/assets/admin/assets/images/icon/logo.png" alt="logo" style="max-width: 100px;">
                </a>
            </div>
        </div>

        <div class="main-menu">
            <div class="menu-inner">
                <nav>
    <ul class="metismenu" id="menu">
        <li><a href="/whey_web/admin"><i class="ti-home"></i><span>Dashboard</span></a></li>
        <li><a href="/whey_web/admin/products"><i class="ti-bag"></i><span>Sản phẩm</span></a></li>
        <li><a href="/whey_web/admin/news"><i class="ti-write"></i><span>Tin tức</span></a></li>
        <li><a href="/whey_web/admin/comments"><i class="ti-comments"></i><span>Bình luận</span></a></li>
        <li><a href="/whey_web/admin/users"><i class="ti-user"></i><span>Người dùng</span></a></li>
        <li><a href="/whey_web/admin/orders"><i class="ti-receipt"></i><span>Đơn hàng</span></a></li>
        
        <li><a href="/whey_web/admin/contacts"><i class="ti-email"></i><span>Liên hệ</span></a></li>
        
        <li><a href="/whey_web/admin/settings"><i class="ti-settings"></i><span>Cài đặt chung</span></a></li>
        <li><a href="/whey_web/admin/settings/about"><i class="ti-info-alt"></i><span>Quản lý Giới thiệu</span></a></li>
    </ul>
</nav>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 clearfix">
                    <div class="user-profile pull-right" style="background: none; padding: 10px 0;">
                        <a href="/whey_web/logout" class="text-danger fw-bold" style="text-decoration: none;">
                            <i class="ti-power-off"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-title-area">
            <div class="row align-items-center" style="padding: 20px 0;">
                <div class="col-sm-12">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title float-start" style="color: #333 !important; font-weight: 700;">
                            <?= htmlspecialchars($title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content-inner">