<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Hệ thống Quản trị - FitWhey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Đường dẫn tuyệt đối /whey_web/ -->
    <link rel="icon" type="image/png" href="/whey_web/public/assets/admin/assets/images/icon/logo.png">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/metismenujs.min.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/styles.css">
    <link rel="stylesheet" href="/whey_web/public/assets/admin/assets/css/responsive.css">

    <style>
        /* Sửa lỗi Sidebar đè nội dung trên màn hình lớn */
        @media (min-width: 992px) {
            .main-content {
                margin-left: 280px; /* Độ rộng chuẩn của Sidebar Srtdash */
                transition: all 0.3s ease;
            }
            /* Khi ẩn sidebar (nếu có chức năng toggle) */
            .sbar_collapsed .main-content {
                margin-left: 0;
            }
        }
        /* Fix khoảng cách header area */
        .header-area {
            padding: 15px 30px;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    
    <div class="page-container">
        <!-- Sidebar Menu -->
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
                            <li class="active">
                                <a href="/whey_web/admin/settings">
                                    <i class="ti-settings"></i><span>Cài đặt hệ thống</span>
                                </a>
                            </li>
                            <li>
                                <a href="/whey_web/admin/contacts">
                                    <i class="ti-email"></i><span>Quản lý liên hệ</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="main-content">
            <!-- Thanh điều hướng trên cùng -->
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <!-- Chỉ giữ duy nhất 1 cụm nav-btn này -->
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
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
            
            <!-- Tìm đoạn này trong header.php -->
            <!-- Tìm và sửa lại đoạn Header chứa tiêu đề Dashboard -->
        <div class="page-title-area">
            <div class="row align-items-center" style="padding: 20px 0;">
                <div class="col-sm-12">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title float-start" style="color: #333 !important; font-weight: 700;">
                            <?php echo $title ?? 'Dashboard'; ?>
                        </h4>
                        <ul class="breadcrumbs float-start" style="margin-top: 5px; margin-left: 15px;">
                            <li><a href="/whey_web/admin">Admin Panel</a></li>
                            <li><span><?php echo $title ?? 'Dashboard'; ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            
            <div class="main-content-inner">