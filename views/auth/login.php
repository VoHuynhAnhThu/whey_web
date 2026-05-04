<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <section class="card form-card">
        <h2>🔐 Đăng Nhập</h2>

        <?php if (!empty($error)): ?>
            <p class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="/whey_web/login" class="form-grid">
            <div>
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" placeholder="your@email.com" required
                    value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Đăng Nhập</button>
        </form>

        <p class="form-hint">Chưa có tài khoản? <a href="/whey_web/register">Tạo tài khoản</a></p>
    </section>
</div>