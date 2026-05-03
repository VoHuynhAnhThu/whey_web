<?php
/** @var array $user */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa người dùng - FITWHEY</title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
    <link rel="stylesheet" href="/whey_web/assets/css/admin-users.css">
</head>
<body>

<main class="container">

    <div class="card form-card">
        <h2 class="form-title">Chỉnh sửa người dùng</h2>
        <form action="/whey_web/admin/users/edit?id=<?= $user['id'] ?>" method="POST" class="form-grid">
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select name="role" id="role">
                    <option value="member" <?= $user['role'] === 'member' ? 'selected' : '' ?>>Thành viên (Member)</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái:</label>
                <select name="status" id="status">
                    <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Kích hoạt</option>
                    <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Bị khóa</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu thay đổi</button>
                <a href="/whey_web/admin/users" class="btn-cancel">Hủy bỏ</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>