<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
</head>

<body class="site site-public">
    <?php $currentUser = Auth::user(); ?>
    <?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $isHome = $currentPath === '/' || $currentPath === '/whey_web/';
    $isProfile = strpos($currentPath, '/profile') === 0;
    $isContact = strpos($currentPath, '/contact') === 0;
    $isNews = strpos($currentPath, '/news') === 0;
    ?>
    <div class="site-page">
        <header class="public-header">
            <div class="public-header__top">
                <a class="brand brand--public" href="/whey_web/" aria-label="FITWHEY home">
                    <span class="logo-block">
                        <span class="logo"></span>
                    </span>
                    <span class="brand__text">
                        <span class="brand-title-block brand-title-block--main">
                            <strong class="brand-title brand-title--main">FITWHEY</strong>
                        </span>
                        <span class="brand-title-block brand-title-block--tagline">
                            <span class="brand-title brand-title--tagline">Sport nutrition</span>
                        </span>
                    </span>
                </a>

                <form class="public-search" method="get" action="/whey_web/news">
                    <input type="search" name="keyword" placeholder="Search..."
                        value="<?= htmlspecialchars((string) ($_GET['keyword'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="47" height="47" viewBox="0 0 47 47" fill="none">
                            <path d="M18.6042 31.3333C15.0465 31.3333 12.0359 30.1009 9.57233 27.636C7.10875 25.1711 5.87631 22.1605 5.875 18.6042C5.8737 15.0478 7.10614 12.0372 9.57233 9.57233C12.0385 7.10744 15.0491 5.875 18.6042 5.875C22.1592 5.875 25.1705 7.10744 27.638 9.57233C30.1055 12.0372 31.3373 15.0478 31.3333 18.6042C31.3333 20.0403 31.1049 21.3948 30.6479 22.6677C30.191 23.9406 29.5708 25.0667 28.7875 26.0458L39.7542 37.0125C40.1132 37.3715 40.2927 37.8285 40.2927 38.3833C40.2927 38.9382 40.1132 39.3951 39.7542 39.7542C39.3951 40.1132 38.9382 40.2927 38.3833 40.2927C37.8285 40.2927 37.3715 40.1132 37.0125 39.7542L26.0458 28.7875C25.0667 29.5708 23.9406 30.191 22.6677 30.6479C21.3948 31.1049 20.0403 31.3333 18.6042 31.3333ZM18.6042 27.4167C21.0521 27.4167 23.1331 26.5602 24.8473 24.8473C26.5615 23.1344 27.418 21.0534 27.4167 18.6042C27.4154 16.1549 26.5589 14.0745 24.8473 12.363C23.1357 10.6514 21.0547 9.79428 18.6042 9.79167C16.1536 9.78906 14.0732 10.6462 12.363 12.363C10.6527 14.0798 9.79558 16.1602 9.79167 18.6042C9.78775 21.0482 10.6448 23.1292 12.363 24.8473C14.0811 26.5654 16.1615 27.4219 18.6042 27.4167Z" fill="black"/>
                        </svg>
                    </button>
                </form>

                <div class="public-header__actions">
                    <?php if ($currentUser === null): ?>
                        <a class="header-action" href="/whey_web/login"><span>
                            <svg class="login-icon" xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                <path d="M9.58331 38.3333V36.4166C9.58331 32.8583 10.9969 29.4457 13.513 26.9296C16.0291 24.4135 19.4417 23 23 23M23 23C26.5583 23 29.9709 24.4135 32.487 26.9296C35.0031 29.4457 36.4166 32.8583 36.4166 36.4166V38.3333M23 23C25.0333 23 26.9834 22.1922 28.4211 20.7544C29.8589 19.3167 30.6666 17.3666 30.6666 15.3333C30.6666 13.3 29.8589 11.3499 28.4211 9.91214C26.9834 8.47436 25.0333 7.66663 23 7.66663C20.9667 7.66663 19.0166 8.47436 17.5788 9.91214C16.141 11.3499 15.3333 13.3 15.3333 15.3333C15.3333 17.3666 16.141 19.3167 17.5788 20.7544C19.0166 22.1922 20.9667 23 23 23Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span> <em>Đăng nhập</em></a>
                    <?php else: ?>
                        <a class="header-action" href="/whey_web/profile"><span>👤</span> <em>Hồ sơ</em></a>
                        <?php if (($currentUser['role'] ?? 'member') === 'admin'): ?>
                            <a class="header-action" href="/whey_web/admin"><span>▣</span> <em>Admin</em></a>
                        <?php endif; ?>
                        <form class="inline-form" method="post" action="/whey_web/logout">
                            <button type="submit" class="header-action header-action--button"><span>⇢</span>
                                <em>Logout</em></button>
                        </form>
                    <?php endif; ?>
                    <a class="header-action header-action--icon" href="#" aria-label="Giỏ hàng">
                        <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                            <path d="M1.91663 3.83337H7.66663L13.4166 24.9167M13.4166 24.9167L11.5 32.5834H40.25M13.4166 24.9167H36.4166L42.1666 7.66671H8.71121L13.4166 24.9167ZM13.4166 40.25C13.4166 40.7584 13.2147 41.2459 12.8552 41.6053C12.4958 41.9648 12.0083 42.1667 11.5 42.1667C10.9916 42.1667 10.5041 41.9648 10.1447 41.6053C9.78523 41.2459 9.58329 40.7584 9.58329 40.25C9.58329 39.7417 9.78523 39.2542 10.1447 38.8948C10.5041 38.5353 10.9916 38.3334 11.5 38.3334C12.0083 38.3334 12.4958 38.5353 12.8552 38.8948C13.2147 39.2542 13.4166 39.7417 13.4166 40.25ZM40.25 40.25C40.25 40.7584 40.048 41.2459 39.6886 41.6053C39.3291 41.9648 38.8416 42.1667 38.3333 42.1667C37.825 42.1667 37.3374 41.9648 36.978 41.6053C36.6186 41.2459 36.4166 40.7584 36.4166 40.25C36.4166 39.7417 36.6186 39.2542 36.978 38.8948C37.3374 38.5353 37.825 38.3334 38.3333 38.3334C38.8416 38.3334 39.3291 38.5353 39.6886 38.8948C40.048 39.2542 40.25 39.7417 40.25 40.25Z" stroke="black" stroke-width="2" stroke-linecap="square"/>
                        </svg>
                        <span class="cart-label">Giỏ hàng</span>
                    </a>
                </div>
            </div>

            <nav class="public-nav" aria-label="Main navigation">
                <a href="/whey_web/" class="<?= $isHome ? 'active' : '' ?>">Trang chủ</a>
                <a href="#">Sản phẩm</a>
                <a href="#">Combo/ Bảng giá</a>
                <a href="/whey_web/news" class="<?= $isNews ? 'active' : '' ?>">Tin tức</a>
                <a href="/whey_web/contact" class="<?= $isContact ? 'active' : '' ?>">Liên hệ &amp; Hỏi đáp</a>
            </nav>
        </header>

        <main class="site-main container">
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

        <footer class="site-footer">
            <div class="site-footer__inner">
                <div class="footer-brand">
                    <div class="footer-brand__row">
                        <span class="footer-brand__logo">↗</span>
                        <div>
                            <strong>FITWHEY</strong>
                            <div>Sport nutrition</div>
                        </div>
                    </div>
                    <p>Địa chỉ cửa hàng: 1000 Phạm Văn Thuận, phường Tam hiệp, tỉnh Đồng nai</p>
                    <p>Hotline &amp; Email: 0909 123 456 | support@fitwhey.vn.</p>
                </div>

                <div class="footer-links">
                    <h3>Danh mục sản phẩm</h3>
                    <a href="#">Whey Protein</a>
                    <a href="#">Sữa tăng cân (Mass)</a>
                    <a href="#">Yến mạch &amp; Ngũ cốc</a>
                    <a href="#">Phụ kiện Gym.</a>
                </div>

                <div class="footer-links">
                    <h3>Hỗ trợ khách hàng</h3>
                    <a href="#">Chính sách đổi trả</a>
                    <a href="#">Phương thức thanh toán</a>
                    <a href="#">Câu hỏi thường gặp (FAQ).</a>
                    <a href="/whey_web/contact">Liên hệ.</a>
                </div>

                <div class="footer-newsletter">
                    <h3>Nhận tin khuyến mãi</h3>
                    <form class="footer-newsletter__form" action="#" method="post">
                        <input type="email" placeholder="Nhập email của bạn" aria-label="Email newsletter">
                        <button type="submit">Đăng kí</button>
                    </form>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>