<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard - FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
</head>

<body class="site site-admin">
    <?php $currentUser = Auth::user(); ?>
    <?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $isAdminHome = $currentPath === '/whey_web/admin' || $currentPath === '/whey_web/admin/';
    $isAdminNews = strpos($currentPath, '/admin/news') === 0;
    $isAdminComments = strpos($currentPath, '/admin/comments') === 0;
    ?>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="brand brand--admin" href="/whey_web/admin" aria-label="FITWHEY admin home">
                <span class="brand__mark brand__mark--admin">↗</span>
                <span class="brand__text">
                    <strong>FITWHEY</strong>
                    <small>Admin panel</small>
                </span>
            </a>

            <nav class="admin-sidebar__nav" aria-label="Admin navigation">
                <a href="/whey_web/admin" class="admin-sidebar__link <?= $isAdminHome ? 'active' : '' ?>">Dashboard</a>
                <a href="#" class="admin-sidebar__link">Quản lý Người dùng</a>
                <a href="#" class="admin-sidebar__link">Quản lý Sản phẩm / Đơn hàng</a>
                <a href="/whey_web/admin/news" class="admin-sidebar__link <?= $isAdminNews ? 'active' : '' ?>">Quản lý
                    Bài viết / Tin tức</a>
                <a href="/whey_web/admin/comments"
                    class="admin-sidebar__link <?= $isAdminComments ? 'active' : '' ?>">Quản lý Liên hệ &amp; Hỏi
                    đáp</a>
                <a href="#" class="admin-sidebar__link">Cài đặt Giao diện</a>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button class="admin-menu-toggle" type="button" aria-label="Open menu">☰</button>
                    <div>
                        <h1><?= htmlspecialchars($title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></h1>
                        <div class="admin-breadcrumb">Home / Dashboard</div>
                    </div>
                </div>

                <div class="admin-topbar__right">
                    <form class="admin-search" method="get" action="/whey_web/admin/news">
                        <input type="search" name="keyword" placeholder="Search...">
                        <button type="submit" aria-label="Search">⌕</button>
                    </form>

                    <button class="admin-icon-btn" type="button" aria-label="Fullscreen">⤢</button>
                    <button class="admin-icon-btn" type="button" aria-label="Notifications">🔔</button>
                    <button class="admin-icon-btn" type="button" aria-label="Messages">✉</button>
                    <button class="admin-icon-btn" type="button" aria-label="Settings">⚙</button>

                    <div class="admin-user-pill">
                        <span
                            class="admin-user-pill__avatar"><?= htmlspecialchars(mb_substr((string) ($currentUser['email'] ?? 'A'), 0, 1), ENT_QUOTES, 'UTF-8') ?></span>
                        <span
                            class="admin-user-pill__name"><?= htmlspecialchars($currentUser['email'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                        <span>▾</span>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                <?php $layoutError = Session::flash('error'); ?>
                <?php $layoutSuccess = Session::flash('success'); ?>

                <?php if (!empty($layoutError)): ?>
                    <p class="alert alert-danger"><?= htmlspecialchars($layoutError, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <?php if (!empty($layoutSuccess)): ?>
                    <p class="alert alert-success"><?= htmlspecialchars($layoutSuccess, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <?= $content ?>
            </main>

            <footer class="admin-footer"></footer>
        </div>
    </div>
</body>

</html>