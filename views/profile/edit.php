<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <section class="card form-card">
        <h2> Hồ Sơ Cá Nhân</h2>

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
                <div class="profile-avatar profile-avatar-placeholder">👤</div>
            <?php endif; ?>
        </div>

        <form method="post" action="/whey_web/profile" enctype="multipart/form-data" class="form-grid">
            <div>
                <label>Email Address</label>
                <input type="email"
                    value="<?= htmlspecialchars((string) ($user['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>

            <div>
                <label for="full_name">Họ và Tên</label>
                <input id="full_name" type="text" name="full_name" placeholder="Nhập tên của bạn"
                    value="<?= htmlspecialchars((string) ($user['full_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div>
                <label for="phone">Số Điện Thoại</label>
                <input id="phone" type="text" name="phone" placeholder="0123456789"
                    value="<?= htmlspecialchars((string) ($user['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div>
                <label for="address">Địa Chỉ</label>
                <input id="address" type="text" name="address" placeholder="Nhập địa chỉ"
                    value="<?= htmlspecialchars((string) ($user['address'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div>
                <label for="bio">Giới Thiệu</label>
                <textarea id="bio" name="bio" placeholder="Viết vài dòng về bạn..."
                    rows="4"><?= htmlspecialchars((string) ($user['bio'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div>
                <label for="avatar">Avatar (JPG, PNG, WEBP - Tối đa 2MB)</label>
                <input id="avatar" type="file" name="avatar"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            </div>

            <button type="submit">Lưu Thay Đổi</button>
        </form>
    </section>
</div>