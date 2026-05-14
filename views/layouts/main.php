<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY - Sport nutrition', ENT_QUOTES, 'UTF-8') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --fit-primary: #10B981; 
            --fit-dark: #222222;
            --text-main: #000000;
        }
        /* Style nút Admin cho nổi bật */
.btn-admin-custom {
    background-color: #F59E0B !important; /* Màu cam vibrance */
    color: #ffffff !important;
    font-weight: 700 !important;
    border: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: 0.3s;
}
.btn-admin-custom:hover {
    background-color: #D97706 !important;
    transform: scale(1.05);
}

        body { 
            font-family: 'Inter', sans-serif; 
            background: #ffffff; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; /* Sửa lỗi cuộn iPad */
            margin: 0; 
            overflow-x: hidden;
        }

        /* --- HEADER TẦNG 1: LOGO - SEARCH - USER --- */
        .site-header { background-color: var(--fit-primary); padding: 12px 0; }
        
        .logo-box { display: flex; align-items: center; text-decoration: none; color: var(--text-main); }
        .logo-img { height: 45px; }

        .search-box-wrapper { flex: 1; max-width: 500px; margin: 0 30px; position: relative; }
        .search-box-wrapper input { width: 100%; padding: 10px 20px 10px 45px; border-radius: 30px; border: none; outline: none; }
        .search-box-wrapper .bi-search { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #888; }

        /* Tối ưu tên user trên Mobile */
        .user-name-text { 
            display: inline-block; 
            max-width: 120px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            vertical-align: middle;
        }

        .header-user-actions a { color: var(--text-main); text-decoration: none; font-weight: 600; }

        /* --- HEADER TẦNG 2: NAVIGATION (NAVBAR) --- */
        .main-nav-bar { background: #fff; border-bottom: 1px solid #eee; }
        .nav-link { color: #333 !important; font-weight: 600; padding: 12px 20px !important; transition: 0.3s; }
        .nav-link:hover { color: var(--fit-primary) !important; }

        /* --- MOBILE FIXES --- */
        @media (max-width: 991px) {
            .search-box-wrapper { display: none; } /* Ẩn search dài trên mobile */
            .user-name-text { display: none; } /* Ẩn email dài */
            .navbar-toggler { border: none; padding: 0; }
            .navbar-collapse { padding: 15px 0; }
            .nav-link { border-bottom: 1px solid #f8f9fa; padding: 15px 0 !important; }
        }

        /* --- FOOTER --- */
        .site-footer { background-color: var(--fit-dark); color: #ffffff; padding: 60px 0 40px; margin-top: auto; }
        .footer-top { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 30px; margin-bottom: 40px; }
        .footer-heading { font-weight: 800; font-size: 1.1rem; margin-bottom: 20px; color: #fff; }
        .footer-link { color: #ccc; text-decoration: none; transition: 0.3s; font-size: 0.95rem; display: block; margin-bottom: 10px; }
        .footer-link:hover { color: var(--fit-primary); }

        .subscribe-input { background: #F3F4F6; border: none; border-radius: 12px; padding: 15px 20px; width: 100%; margin-bottom: 10px; }
        .btn-subscribe { background: #fff; color: var(--fit-primary); border: 2px solid var(--fit-primary); border-radius: 25px; padding: 8px 25px; font-weight: 600; float: right; }
    </style>
</head>

<body>
    <?php 
        $currentUser = Auth::user(); 
        $displayUser = null;
        if ($currentUser !== null) {
            $userModel = new User();
            $displayUser = $userModel->findById($currentUser['id']);
        }

    ?>
    
    <header class="site-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="/whey_web/" class="logo-box">
                    <img src="/whey_web/assets/images/logo.png" alt="Logo" class="logo-img">
                    <div class="logo-text d-none d-md-block ms-2">
                        <h1 class="h4 fw-bold m-0">FITWHEY</h1>
                        <span class="small italic">Sport nutrition</span>
                    </div>
                </a>

                <div class="search-box-wrapper d-none d-lg-block">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Tìm kiếm sản phẩm thực phẩm thể hình...">
                </div>

                <div class="header-user-actions d-flex align-items-center gap-3">
                    <a href="#" class="d-lg-none"><i class="bi bi-search fs-4"></i></a>
                    
                    <?php if ($currentUser === null): ?>
                        <a href="/whey_web/login"><i class="bi bi-person fs-4"></i></a>
                    <?php else: ?>
                        <?php if (Auth::isAdmin()): ?>
                            <a href="/whey_web/admin" class="btn btn-sm btn-light rounded-pill px-3">Quản trị</a>
                        <?php endif; ?>
                        <a href="/whey_web/profile" class="text-white fw-bold">Hi, <?= htmlspecialchars($displayUser['full_name'] ??  'User') ?></a>
                        <a href="/whey_web/logout" title="Đăng xuất"><i class="bi bi-box-arrow-right fs-4 text-white"></i></a>
                    <?php endif; ?>
                    
                    <a href="/whey_web/cart" class="ms-1"><i class="bi bi-cart3 fs-4"></i></a>

                    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#fitNav">
                        <i class="bi bi-list fs-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <nav class="main-nav-bar navbar navbar-expand-lg py-0 shadow-sm">
        <div class="container">
            <div class="collapse navbar-collapse justify-content-center" id="fitNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item"><a class="nav-link" href="/whey_web/">TRANG CHỦ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/whey_web/about">GIỚI THIỆU</a></li>
                    <li class="nav-item"><a class="nav-link" href="/whey_web/products">SẢN PHẨM</a></li>
                    <?php if ($currentUser !== null): ?>
                        <li class="nav-item"><a class="nav-link" href="/whey_web/orders">ĐƠN HÀNG CỦA TÔI</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/whey_web/news">TIN TỨC</a></li>
                    <li class="nav-item"><a class="nav-link" href="/whey_web/contact">LIÊN HỆ & HỎI ĐÁP</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="d-flex align-items-start gap-3">
                    <img src="/whey_web/assets/images/logo.png" alt="FITWHEY" style="height: 50px;">
                    <div>
                        <h4 class="fw-bold m-0 text-white">FITWHEY</h4>
                        <div class="footer-info-text mt-2">
                            📍 Địa chỉ cửa hàng: <?= htmlspecialchars($settings['site_address'] ?? '1000 Phạm Văn Thuận, Biên Hòa, Đồng Nai') ?> <br>
                            📞 Hotline & Email: <?= htmlspecialchars($settings['site_hotline'] ?? '0909 123 456') ?> | support@fitwhey.vn
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 text-center text-lg-start">
                <div class="col-lg-4">
                    <h6 class="footer-heading">Danh mục sản phẩm</h6>
                    <a href="#" class="footer-link">Whey Protein</a>
                    <a href="#" class="footer-link">Sữa tăng cân (Mass)</a>
                    <a href="#" class="footer-link">Yến mạch & Ngũ cốc</a>
                    <a href="#" class="footer-link">Phụ kiện Gym</a>
                </div>

                <div class="col-lg-4">
                    <h6 class="footer-heading">Hỗ trợ khách hàng</h6>
                    <a href="#" class="footer-link">Chính sách đổi trả</a>
                    <a href="#" class="footer-link">Phương thức thanh toán</a>
                    <a href="/whey_web/contact" class="footer-link">Liên hệ</a>
                    <a href="/whey_web/about" class="footer-link">Về chúng tôi</a>
                </div>

                <div class="col-lg-4">
                    <h6 class="footer-heading">Nhận tin khuyến mãi</h6>
                    <div class="subscribe-container mx-auto mx-lg-0">
                        <input type="email" class="subscribe-input" placeholder="Nhập email của bạn">
                        <button class="btn-subscribe">Đăng ký</button>
                    </div>
                </div>
            </div>
            
            <hr class="mt-5 opacity-10">
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>