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
            /* Các màu dùng để thiết kế các trang từ Figma */
            --fit-primary: #10B981; 
            --fit-dark: #333333;
            --fit-error: #EF4444;
            --fit-light-green: #3EED5E;
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
        }

        /* --- HEADER CHUẨN FIGMA --- */
        .site-header {
            background-color: var(--fit-primary);
            padding-top: 4px; /* Khoảng cách 4px phía trên theo Figma */
            padding-bottom: 15px;
        }

        .header-main-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }

        /* Logo FITWHEY */
        .logo-box {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-main);
        }
        .logo-img {
            height: 45px;
            margin-right: 10px;
        }
        .logo-text h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }
        .logo-text span {
            font-size: 14px;
            font-style: italic;
            font-weight: 400;
        }

        /* Ô nhập liệu Tìm kiếm */
        .search-box-wrapper {
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
            position: relative;
        }
        .search-box-wrapper input {
            width: 100%;
            padding: 8px 15px 8px 45px;
            border-radius: 25px; /* Bo tròn theo Figma */
            border: none;
            background: #ffffff;
            outline: none;
            font-size: 14px;
        }
        .search-box-wrapper .bi-search {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #000;
            font-weight: bold;
        }

        /* Actions: Đăng nhập & Giỏ hàng */
        .header-user-actions {
            display: flex;
            gap: 20px;
        }
        .header-user-actions a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Navigation Menu bên dưới */
        .header-nav {
            display: flex;
            justify-content: center;
            gap: 35px;
            margin-top: 10px;
        }
        .header-nav a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        /* --- TYPOGRAPHY THEO FIGMA --- */
        h1 { font-size: 32px; font-weight: 700; }
        h2 { font-size: 24px; font-weight: 700; }
        h3 { font-size: 20px; font-weight: 700; }

        /* --- NÚT BẤM --- */
        .btn-fit-primary {
            background-color: var(--fit-primary);
            color: white;
            border-radius: 12px;
            padding: 10px 25px;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-fit-primary:hover {
            background-color: #0E9F6E; /* Trạng thái hover đậm hơn chút */
        }

        /* --- Ô NHẬP LIỆU (Dùng cho các trang con) --- */
        .fit-input {
            background: var(--fit-bg-light);
            border: 1px solid transparent;
            border-radius: 15px;
            padding: 15px 20px;
            width: 100%;
            outline: none;
        }
        .fit-input.error {
            border-color: var(--fit-error);
        }

        /* --- FOOTER THEO FIGMA --- */
        .site-footer {
            background-color: var(--fit-dark);
            color: #ffffff;
            padding: 50px 0 20px;
            margin-top: auto;
        }
        .footer-logo { font-size: 28px; font-weight: 800; margin-bottom: 10px; }
        .footer-sub { font-size: 14px; color: #ccc; }
        
        .subscribe-box {
            background: #ffffff;
            border-radius: 15px;
            padding: 5px;
            display: flex;
            align-items: center;
        }
        .subscribe-box input {
            border: none;
            padding: 10px;
            flex: 1;
            outline: none;
            border-radius: 15px;
        }
        .btn-subscribe-small {
            background-color: var(--fit-primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }
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
                        <h1>FITWHEY</h1>
                        <span>Sport nutrition</span>
                    </div>
                </a>

                <div class="search-box-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                </div>

                <div class="header-user-actions d-flex align-items-center">
                        <?php if ($currentUser === null): ?>
                            <a href="/whey_web/login"><i class="bi bi-person fs-4"></i> Đăng nhập</a>
                        <?php else: ?>
                            <a href="/whey_web/profile" class="me-3">
                                <i class="bi bi-person-check-fill fs-4 text-white"></i> 
                                <span class="text-white fw-bold">
                                    <?= htmlspecialchars($currentUser['name'] ?? explode('@', $currentUser['email'])[0]) ?>
                                </span>
                            </a>
                            
                            <form action="/whey_web/logout" method="GET" class="m-0">
                                <button type="submit" class="btn btn-sm btn-outline-light border-0" title="Đăng xuất">
                                    <i class="bi bi-box-arrow-right fs-4"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <a href="/whey_web/cart" class="ms-3"><i class="bi bi-cart3 fs-4"></i> Giỏ hàng</a>
                    </div>
                </div>

            <nav class="header-nav">
                <a href="/whey_web/">Trang chủ</a>
                <a href="/whey_web/products">Sản phẩm</a>
                <a href="#">Combo/ Bảng giá</a>
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
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-logo">FITWHEY</div>
                    <p class="footer-sub">📍 Địa chỉ cửa hàng: <?= htmlspecialchars($settings['site_address'] ?? '1000 Phạm Văn Thuận, Biên Hòa, Đồng Nai') ?></p>
                    <p class="footer-sub">📞 Hotline: <?= htmlspecialchars($settings['site_phone'] ?? '0909 123 456') ?> | support@fitwhey.vn</p>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Danh mục sản phẩm</h6>
                    <p class="small mb-2">Whey Protein</p>
                    <p class="small mb-2">Sữa tăng cân (Mass)</p>
                    <p class="small mb-2">Yến mạch & Ngũ cốc</p>
                    <p class="small mb-2">Phụ kiện Gym</p>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Hỗ trợ khách hàng</h6>
                    <p class="small mb-2">Chính sách đổi trả</p>
                    <p class="small mb-2">Phương thức thanh toán</p>
                    <p class="small mb-2">Câu hỏi thường gặp (FAQ)</p>
                    <p class="small mb-2">Liên hệ</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Nhận tin khuyến mãi</h6>
                    <div class="subscribe-box">
                        <input type="email" placeholder="Nhập email của bạn">
                        <button class="btn-subscribe-small">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>