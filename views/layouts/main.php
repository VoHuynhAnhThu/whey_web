<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
</head>

<body>
    <?php $currentUser = Auth::user(); ?>
    <header class="site-header">
        <div class="container">
            <h1 class="brand">FITWHEY</h1>
            <nav>
                <a href="/whey_web/">Home</a>
                <a href="/whey_web/about">About</a>
                <a href="/whey_web/products">Products</a>
                <?php if ($currentUser === null): ?>
                    <a href="/whey_web/register">Register</a>
                    <a href="/whey_web/login">Login</a>
                <?php else: ?>
                    <a href="/whey_web/profile">Profile</a>
                    <?php if (($currentUser['role'] ?? 'member') === 'admin'): ?>
                        <a href="/whey_web/admin">Admin</a>
                        <a href="/whey_web/admin/products">Manage Products</a>
                        <a href="/whey_web/admin/orders">Manage Orders</a>
                    <?php elseif (($currentUser['role'] ?? 'member') === 'member'): ?>
                        <a href="/whey_web/orders">My Orders</a>
                        <a href="/whey_web/cart">Cart</a>
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