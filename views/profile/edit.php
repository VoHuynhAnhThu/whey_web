<section class="card form-card">
    <h2>Ho so ca nhan</h2>

    <?php if (!empty($error)): ?>
        <p class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <div class="profile-avatar-wrap">
        <?php if (!empty($user['avatar_url'])): ?>
            <img class="profile-avatar" src="<?= htmlspecialchars((string) $user['avatar_url'], ENT_QUOTES, 'UTF-8') ?>"
                alt="Avatar">
        <?php else: ?>
            <div class="profile-avatar profile-avatar-placeholder">No avatar</div>
        <?php endif; ?>
    </div>

    <form method="post" action="/whey_web/profile" enctype="multipart/form-data" class="form-grid">
        <label>Email</label>
        <input type="email" value="<?= htmlspecialchars((string) ($user['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
            disabled>

        <label for="full_name">Ho ten</label>
        <input id="full_name" type="text" name="full_name"
            value="<?= htmlspecialchars((string) ($user['full_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label for="phone">So dien thoai</label>
        <input id="phone" type="text" name="phone"
            value="<?= htmlspecialchars((string) ($user['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label for="address">Dia chi</label>
        <input id="address" type="text" name="address"
            value="<?= htmlspecialchars((string) ($user['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label for="bio">Gioi thieu</label>
        <textarea id="bio" name="bio"
            rows="4"><?= htmlspecialchars((string) ($user['bio'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>

        <label for="avatar">Avatar (JPG, PNG, WEBP, toi da 2MB)</label>
        <input id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

        <button type="submit">Luu thay doi</button>
    </form>
</section>