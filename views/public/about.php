<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/whey_web/assets/css/about.css">
</head>
<body>
    <section class="card">
        <h2><?= htmlspecialchars($heading ?? 'About Us', ENT_QUOTES, 'UTF-8') ?></h2>

        <div class="about-content">
            <p><?= nl2br(htmlspecialchars($content ?? 'Nội dung đang cập nhật...')) ?></p>
        </div>

        <?php if (!empty($image)): ?>
            <div class="about-image" style="margin-top: 20px;">
                <img src="<?= htmlspecialchars($image) ?>" alt="FITWHEY About" style="max-width: 100%; height: auto;">
            </div>
        <?php endif; ?>
    </section>
</body>
</html>