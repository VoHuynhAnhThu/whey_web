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
            --fit-dark: #222222; /* Màu nền footer tối hơn theo ảnh */
            --fit-bg-light: #F3F4F6;
            --text-main: #000000;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background: #ffffff; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            margin: 0; 
            overflow-x: hidden;
        }

        /* --- HEADER --- */
        .site-header { background-color: var(--fit-primary); padding: 10px 0; }
        .header-main-row { display: flex; align-items: center; justify-content: space-between; }
        .logo-box { display: flex; align-items: center; text-decoration: none; color: var(--text-main); }
        .logo-img { height: 45px; margin-right: 10px; }
        .search-box-wrapper { flex: 1; max-width: 400px; margin: 0 20px; position: relative; }
        .search-box-wrapper input { width: 100%; padding: 8px 15px 8px 45px; border-radius: 25px; border: none; outline: none; }
        .search-box-wrapper .bi-search { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); }
        .header-user-actions { display: flex; gap: 15px; align-items: center; }
        .header-user-actions a { color: var(--text-main); text-decoration: none; font-weight: 500; }
        .header-nav { display: flex; justify-content: center; gap: 35px; margin-top: 15px; }
        .header-nav a { color: var(--text-main); text-decoration: none; font-weight: 500; }

        /* --- FOOTER CHUẨN ẢNH --- */
        .site-footer {
            background-color: var(--fit-dark);
            color: #ffffff;
            padding: 60px 0 40px;
            margin-top: auto;
        }
        .footer-top { border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 30px; margin-bottom: 40px; }
        .footer-info-text { font-size: 0.95rem; color: #ccc; line-height: 1.6; }
        .footer-heading { font-weight: 800; font-size: 1.1rem; margin-bottom: 20px; color: #fff; }
        .footer-link { color: #ccc; text-decoration: none; transition: 0.3s; font-size: 0.95rem; display: block; margin-bottom: 10px; }
        .footer-link:hover { color: var(--fit-primary); }

        /* Ô nhận tin khuyến mãi */
        .subscribe-container { max-width: 400px; }
        .subscribe-input {
            background: #F3F4F6;
            border: none;
            border-radius: 15px;
            padding: 20px 25px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 1rem;
            color: #333;
        }
        .btn-subscribe {
            background: #fff;
            color: var(--fit-primary);
            border: 2px solid var(--fit-primary);
            border-radius: 25px;
            padding: 8px 30px;
            font-weight: 600;
            float: right;
            transition: 0.3s;
        }
        .btn-subscribe:hover { background: var(--fit-primary); color: #fff; }
    </style>
</head>

<body>
    <?php $currentUser = Auth::user(); ?>
    
    <header class="site-header">
        <div class="container">
            <div class="header-main-row">
                <a href="/whey_web/" class="logo-box">
                    <img src="/whey_web/assets/images/logo.png" alt="Logo" class="logo-img">
                    <div class="logo-text">
                        <h1 class="h4 fw-bold m-0">FITWHEY</h1>
                        <span class="small italic">Sport nutrition</span>
                    </div>
                </a>
                <div class="search-box-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                </div>
                <div class="header-user-actions">
                    <?php if ($currentUser === null): ?>
                        <a href="/whey_web/login"><i class="bi bi-person fs-4"></i> Đăng nhập</a>
                    <?php else: ?>
                        <?php if (Auth::isAdmin()): ?>
                            <a href="/whey_web/admin" class="btn btn-sm btn-light rounded-pill px-3">Quản trị</a>
                        <?php endif; ?>
                        <a href="/whey_web/profile" class="text-white fw-bold">Hi, <?= htmlspecialchars($currentUser['email']) ?></a>
                        <a href="/whey_web/logout" title="Đăng xuất"><i class="bi bi-box-arrow-right fs-4 text-white"></i></a>
                    <?php endif; ?>
                    <a href="/whey_web/cart" class="ms-2"><i class="bi bi-cart3 fs-4 text-white"></i></a>
                </div>
            </div>
            <nav class="header-nav">
                <a href="/whey_web/">Trang chủ</a>
                <a href="/whey_web/about">Giới thiệu</a>
                <a href="/whey_web/products">Sản phẩm</a>
                <a href="/whey_web/news">Tin tức</a>
                <a href="/whey_web/contact">Liên hệ & Hỏi đáp</a>
            </nav>
        </div>
    </header>

    <main class="py-5">
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

            <div class="row g-4">
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
                    <a href="#" class="footer-link">Câu hỏi thường gặp (FAQ)</a>
                    <a href="/whey_web/contact" class="footer-link">Liên hệ</a>
                    <a href="/whey_web/about" class="footer-link">Về chúng tôi</a>
                </div>

                <div class="col-lg-4">
                    <h6 class="footer-heading">Nhận tin khuyến mãi</h6>
                    <div class="subscribe-container">
                        <input type="email" class="subscribe-input" placeholder="Nhập email của bạn">
                        <button class="btn-subscribe">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>