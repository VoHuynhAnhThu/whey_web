<section class="card form-card">
    <h2>Dang nhap</h2>

    <?php if (!empty($error)): ?>
        <p class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="/whey_web/login" class="form-grid">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required
            value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label for="password">Mat khau</label>
        <input id="password" type="password" name="password" required>

        <button type="submit">Dang nhap</button>
    </form>

    <p class="form-hint">Chua co tai khoan? <a href="/whey_web/register">Sign Up</a>.</p>
</section>