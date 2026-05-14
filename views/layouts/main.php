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
            --fit-dark: #333333;
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

        .site-header {
            background-color: var(--fit-primary);
            padding-top: 4px;
            padding-bottom: 15px;
        }

        .header-main-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }

        .logo-box {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-main);
        }
        .logo-img { height: 45px; margin-right: 10px; }
        
        .search-box-wrapper {
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
            position: relative;
        }
        .search-box-wrapper input {
            width: 100%;
            padding: 8px 15px 8px 45px;
            border-radius: 25px;
            border: none;
            outline: none;
        }
        .search-box-wrapper .bi-search {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
        }

        .header-user-actions { display: flex; gap: 15px; }
        .header-user-actions a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

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
        }

        /* Style cho nút Admin */
        .btn-admin-link {
            background: rgba(255, 255, 255, 0.25);
            padding: 5px 15px;
            border-radius: 20px;
            color: white !important;
            transition: 0.3s;
        }
        .btn-admin-link:hover {
            background: rgba(255, 255, 200, 0.4);
        }

        .site-footer {
            background-color: var(--fit-dark);
            color: #ffffff;
            padding: 50px 0 20px;
            margin-top: auto;
        }
        .footer-sub { font-size: 14px; color: #ccc; }
    </style>
</head>

<body>
    <?php $currentUser = Auth::user(); ?>
    
    <header class="site-header">
        <div class="container">
            <div class="header-main-row">
                <a href="/whey_web/" class="logo-box">
                    <img src="<?= !empty($settings['site_logo']) ? '/whey_web/public/uploads/'.$settings['site_logo'] : '/whey_web/assets/images/logo.png' ?>" alt="Logo" class="logo-img">
                    <div class="logo-text">
                        <h1 class="h4 fw-bold m-0">FITWHEY</h1>
                        <span class="small italic">Sport nutrition</span>
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
                        <?php if (Auth::isAdmin()): ?>
                            <a href="/whey_web/admin" class="btn-admin-link me-2">
                                <i class="bi bi-shield-lock"></i> Quản trị
                            </a>
                        <?php endif; ?>

                        <a href="/whey_web/profile" class="me-2">
                            <i class="bi bi-person-circle fs-4 text-white"></i> 
                            <span class="text-white fw-bold">
                                <?= htmlspecialchars($currentUser['email'] ?? 'User') ?>
                            </span>
                        </a>
                        
                        <a href="/whey_web/logout" class="text-white ms-2" title="Đăng xuất">
                            <i class="bi bi-box-arrow-right fs-4"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="/whey_web/cart" class="ms-3"><i class="bi bi-cart3 fs-4"></i></a>
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
            <?php if ($msg = Session::flash('success')): ?>
                <div class="alert alert-success"><?= $msg ?></div>
            <?php endif; ?>
            <?php if ($msg = Session::flash('error')): ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">FITWHEY</h5>
                    <p class="footer-sub">📍 <?= htmlspecialchars($settings['site_address'] ?? 'Biên Hòa, Đồng Nai') ?></p>
                    <p class="footer-sub">📞 Hotline: <?= htmlspecialchars($settings['site_hotline'] ?? '0909 123 456') ?></p>
                </div>
                <div class="col-lg-4 text-center">
                    <h6 class="fw-bold mb-3">HỖ TRỢ</h6>
                    <p class="small mb-1"><a href="/whey_web/about" class="text-white text-decoration-none">Về chúng tôi</a></p>
                    <p class="small mb-1">Chính sách bảo mật</p>
                </div>
                <div class="col-lg-4 text-end">
                    <h6 class="fw-bold mb-3">BÀI TẬP LỚN</h6>
                    <p class="small opacity-50">&copy; 2026 Project Web Programming</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>