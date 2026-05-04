<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'FITWHEY', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
</head>

<body class="site site-auth">
    <main class="auth-page-wrap">
        <?php $layoutError = Session::flash('error'); ?>
        <?php $layoutSuccess = Session::flash('success'); ?>

        <?php if (!empty($layoutError)): ?>
            <p class="alert alert-danger auth-page-message"><?= htmlspecialchars($layoutError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <?php if (!empty($layoutSuccess)): ?>
            <p class="alert alert-success auth-page-message"><?= htmlspecialchars($layoutSuccess, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>

</html>