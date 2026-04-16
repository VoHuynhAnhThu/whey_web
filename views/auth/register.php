<section class="card form-card">

    <?php if (!empty($error)): ?>
        <p class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="/whey_web/register" class="form-grid">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required
            value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label for="password">Mat khau</label>
        <input id="password" type="password" name="password" required>

        <label for="confirm_password">Xac nhan mat khau</label>
        <input id="confirm_password" type="password" name="confirm_password" required>

        <button type="submit">Tao tai khoan</button>
    </form>

    <p class="form-hint">Da co tai khoan? <a href="/whey_web/login">Login</a>.</p>
</section>