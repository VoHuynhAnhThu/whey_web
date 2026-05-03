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
            <h2 class="user-table-title">Quản lý người dùng</h2>

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
            <span class="divider">|</span>
            <a class="action-link delete-link" 
               href="/whey_web/admin/users/delete?id=<?= $user['id'] ?>" 
               onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                Xóa
            </a>
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