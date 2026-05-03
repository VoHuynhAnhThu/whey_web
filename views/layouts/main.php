<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
    <!-- Tui thêm một chút CSS trực tiếp để xử lý nhanh phần Layout theo Figma -->
    <style>
        :root { --sidebar-bg: #2c2c2c; --main-bg: #f4f7f6; --green-fit: #28a745; }
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--main-bg); }
        .wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar theo Figma */
        .sidebar { width: 260px; background: var(--sidebar-bg); color: #fff; transition: all 0.3s; }
        .sidebar .logo-box { padding: 20px; text-align: center; border-bottom: 1px solid #444; }
        .sidebar nav a { display: block; padding: 15px 25px; color: #adb5bd; text-decoration: none; transition: 0.2s; }
        .sidebar nav a:hover { background: #3d3d3d; color: var(--green-fit); }
        .sidebar nav a.active { color: #fff; border-left: 4px solid var(--green-fit); background: #3d3d3d; }

        /* Main Content */
        .main-content { flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; height: 60px; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .user-profile { background: var(--green-fit); color: #fff; padding: 5px 15px; border-radius: 4px; display: flex; align-items: center; }

        /* Responsive */
        @media (max-width: 768px) {
            .wrapper { flex-direction: column; }
            .sidebar { width: 100%; height: auto; }
            .sidebar .logo-box { padding: 10px; }
        }
    </style>
</head>

<body>
    <?php $currentUser = Auth::user(); ?>

    <div class="wrapper">
        <!-- SIDEBAR - Theo đúng bản thiết kế image_0b6c60.png -->
        <aside class="sidebar">
            <div class="logo-box">
                <a href="/whey_web/">
                    <?php if (!empty($settings['site_logo'])): ?>
                        <img src="<?= $settings['site_logo'] ?>" alt="FITWHEY" style="max-height: 80px;">
                    <?php else: ?>
                        <h2 style="color: var(--green-fit);">FITWHEY</h2>
                    <?php endif; ?>
                </a>
            </div>
            <nav class="mt-3">
                <a href="/whey_web/" class="active">Dashboard</a>
                <a href="#">Quản lý Người dùng</a>
                <a href="#">Quản lý Sản phẩm / Đơn hàng</a>
                <a href="#">Quản lý Bài viết / Tin tức</a>
                <a href="/whey_web/admin/contacts">Quản lý Liên hệ & Hỏi đáp</a>
                <a href="/whey_web/admin/settings">Cài đặt Giao diện</a>
            </nav>
        </aside>

        <!-- PHẦN NỘI DUNG CHÍNH -->
        <div class="main-content">
            <!-- TOPBAR -->
            <header class="topbar">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <div class="top-right d-flex align-items-center">
                    <?php if ($currentUser): ?>
                        <div class="user-profile">
                            <span>Hi, <?= htmlspecialchars($currentUser['full_name'] ?? 'Nguyễn Chí Thanh') ?></span>
                            <form action="/whey_web/logout" method="post" style="margin-left: 15px; display: inline;">
                                <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer;">Logout</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <a href="/whey_web/login" class="btn btn-sm btn-outline-success">Login</a>
                    <?php endif; ?>
                </div>
            </header>

            <!-- NỘI DUNG DỘNG (CONTENT AREA) -->
            <main class="p-4">
                <!-- Thông báo hệ thống -->
                <?php if ($msg = Session::flash('error')): ?>
                    <div class="alert alert-danger"><?= $msg ?></div>
                <?php endif; ?>
                <?php if ($msg = Session::flash('success')): ?>
                    <div class="alert alert-success"><?= $msg ?></div>
                <?php endif; ?>

                <div class="content-body">
                    <?= $content ?>
                </div>
            </main>

            <!-- FOOTER DƯỚI CÙNG -->
            <footer class="p-4 mt-auto border-top bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <strong>FITWHEY - Thực phẩm thể hình</strong>
                        <p class="small text-muted mb-0"><?= $settings['site_intro'] ?? 'Chuyên cung cấp Whey Protein chính hãng.'; ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small>📍 <?= $settings['site_address'] ?? 'Biên Hòa, Đồng Nai'; ?></small><br>
                        <small>📞 <?= $settings['site_phone'] ?? '0377xxxxxx'; ?></small>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>