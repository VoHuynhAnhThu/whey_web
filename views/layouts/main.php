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
    <?php $currentUser = Auth::user(); ?>
    <header class="site-header">
        <div class="container">
            <h1 class="brand">FITWHEY</h1>
            <nav>
                <a href="/whey_web/">Home</a>
                <a href="/whey_web/about">About</a>
                <?php if ($currentUser === null): ?>
                    <a href="/whey_web/register">Register</a>
                    <a href="/whey_web/login">Login</a>
                <?php else: ?>
                    <a href="/whey_web/profile">Profile</a>
                    <?php if (($currentUser['role'] ?? 'member') === 'admin'): ?>
                        <a href="/whey_web/admin">Admin</a>
                    <?php endif; ?>
                    <form class="inline-form" method="post" action="/whey_web/logout">
                        <button type="submit" class="link-button">Logout</button>
                    </form>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
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
</body>
</html>