<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <!-- Link tới file CSS của bạn và Bootstrap để dựng Layout nhanh -->
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { --green-fit: #28a745; --dark-fit: #333333; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f7f6; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            margin: 0; 
        }
        
        /* Chỉnh Header theo Figma */
        .public-header { background: var(--green-fit); color: white; padding: 15px 0; }
        .logo-text { font-size: 28px; font-weight: 900; font-style: italic; letter-spacing: 1px; }
        
        /* Chỉnh thanh Search */
        .search-wrapper { position: relative; width: 100%; max-width: 500px; }
        .search-wrapper input { padding-left: 40px; border-radius: 20px; }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; }
        
        /* Chỉnh Menu */
        .nav-menu { background: #1a8a33; padding: 10px 0; }
        .nav-menu a { color: white; margin: 0 20px; text-decoration: none; font-weight: 500; font-size: 16px; }
        .nav-menu a:hover { color: #d4edda; }
        
        /* Đẩy footer xuống đáy */
        main { flex: 1; } 
        
        /* Chỉnh Footer theo Figma */
        .footer-dark { background: var(--dark-fit); color: #ccc; padding: 40px 0 20px; margin-top: auto; }
        .footer-dark h5 { color: white; font-weight: bold; margin-bottom: 20px; }
        .footer-dark ul { padding-left: 0; }
        .footer-dark ul li { margin-bottom: 10px; cursor: pointer; }
        .footer-dark ul li:hover { color: white; }
        .footer-dark p { margin-bottom: 5px; font-size: 14px; }
    </style>
</head>
<body>
    <?php 
        // FIX LỖI: Kiểm tra an toàn xem Auth có tồn tại và trả về user không
        $currentUser = (class_exists('Auth') && method_exists('Auth', 'user')) ? Auth::user() : null; 
    ?>

    <!-- HEADER -->
    <header class="public-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
    <a href="/whey_web/" class="d-flex align-items-center text-decoration-none">
        
        <!-- 1. Hiển thị Logo (Nếu có) -->
        <?php if (!empty($settings['site_logo'])): ?>
            <img src="/whey_web/public/uploads/<?php echo htmlspecialchars($settings['site_logo'], ENT_QUOTES, 'UTF-8'); ?>" 
                 alt="FITWHEY Logo" 
                 style="height: 40px; width: auto;" 
                 class="me-2">
        <?php endif; ?>

        <!-- 2. Luôn hiển thị tên thương hiệu để giữ thẩm mỹ -->
        <div class="d-flex flex-column justify-content-center">
            <span class="logo-text" style="font-weight: 800; color: white; font-size: 1.6rem; line-height: 1;">FITWHEY</span>
            <span class="text-white-50" style="font-size: 0.85rem; letter-spacing: 1px;">Sport nutrition</span>
        </div>

    </a>
</div>
            
            <div class="search-wrapper mx-4">
                <span class="search-icon">🔍</span>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Tìm kiếm sản phẩm...">
            </div>
            
            <div class="auth-buttons d-flex align-items-center">
                <?php if ($currentUser): ?>
                    <!-- FIX LỖI: Sử dụng toán tử ?? để tránh lỗi Null -->
                    <span class="me-3">Hi, <?= htmlspecialchars($currentUser['full_name'] ?? 'Khách', ENT_QUOTES, 'UTF-8') ?></span>
                    <a href="/whey_web/logout" class="text-white text-decoration-none">Đăng xuất</a>
                <?php else: ?>
                    <a href="/whey_web/login" class="text-white text-decoration-none me-4">👤 Đăng nhập</a>
                    <a href="/whey_web/cart" class="text-white text-decoration-none">🛒 Giỏ hàng</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- MENU -->
    <nav class="nav-menu">
        <div class="container d-flex justify-content-center">
            <a href="/whey_web/">Trang chủ</a>
            <a href="/whey_web/products">Sản phẩm</a>
            <a href="/whey_web/combo">Combo/ Bảng giá</a>
            <a href="/whey_web/news">Tin tức</a>
            <a href="/whey_web/contact">Liên hệ & Hỏi đáp</a>
        </div>
    </nav>

    <!-- NỘI DUNG CHÍNH (FORM LIÊN HỆ SẼ NẰM Ở ĐÂY) -->
    <main class="py-5">
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="logo-text text-success mb-3">FITWHEY</h4>
                    <p>Địa chỉ cửa hàng: <?= htmlspecialchars($settings['site_address'] ?? '1000 Phạm Văn Thuận, phường Tam Hiệp, tỉnh Đồng Nai', ENT_QUOTES, 'UTF-8') ?></p>
                    <p>Hotline & Email: <?= htmlspecialchars($settings['site_phone'] ?? '0909 123 456', ENT_QUOTES, 'UTF-8') ?> | support@fitwhey.vn</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Danh mục sản phẩm</h5>
                    <ul class="list-unstyled text-light-50">
                        <li>Whey Protein</li>
                        <li>Sữa tăng cân (Mass)</li>
                        <li>Yến mạch & Ngũ cốc</li>
                        <li>Phụ kiện Gym</li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Hỗ trợ khách hàng</h5>
                    <ul class="list-unstyled text-light-50">
                        <li>Chính sách đổi trả</li>
                        <li>Phương thức thanh toán</li>
                        <li>Câu hỏi thường gặp (FAQ)</li>
                        <li>Liên hệ</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Nhận tin khuyến mãi</h5>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        <button class="btn btn-light text-success fw-bold">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>