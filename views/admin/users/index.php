<?php
/** @var array $users */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý User</title>
    <link rel="stylesheet" href="/whey_web/assets/css/app.css">
    <link rel="stylesheet" href="/whey_web/assets/css/admin-users.css">
</head>
<body>

<main class="container">
    <div class="card">
        <div class="user-table-wrapper">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="user-table-title" style="margin: 0;">Quản lý người dùng</h2>
                
                <a href="/whey_web/admin/users/add" style="padding: 10px 16px; background-color: #2ECC71; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px; transition: opacity 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <span>➕</span> Thêm người dùng mới
                </a>
            </div>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>HỌ TÊN</th>
                        <th>EMAIL</th>
                        <th>VAI TRÒ</th>
                        <th>TRẠNG THÁI</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="font-bold"><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></td>
                        <td class="text-muted"><?= htmlspecialchars($user['email']) ?></td>

                        <td>
                            <span class="badge <?= ($user['role'] === 'admin') ? 'role-admin' : 'role-member' ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>

                        <td>
                            <span class="badge <?= ($user['status'] === 'active') ? 'status-active' : 'status-inactive' ?>">
                                <?= ($user['status'] === 'active') ? 'Kích hoạt' : 'Khóa' ?>
                            </span>
                        </td>

                        <td class="actions">
    <a class="action-link edit-link" href="/whey_web/admin/users/edit?id=<?= $user['id'] ?>">Sửa</a>

    <?php if ($user['id'] !== ($_SESSION['user_id'] ?? '')): ?>
        <span class="divider">|</span>
        <a class="action-link delete-link" 
           href="/whey_web/admin/users/delete?id=<?= $user['id'] ?>" 
           onclick="return confirm('Bạn chắc chắn muốn xóa?')">
            Xóa
        </a>
    <?php endif; ?>
</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        </div>
    </div>
</main>

</body>
</html>