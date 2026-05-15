<?php
/** @var array $users */
// Lưu ý: Không thêm <html>, <head>, <body> vào đây vì đã có Layout 'admin' lo rồi
?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0" style="font-weight: 700; color: #333;">Danh sách người dùng</h4>
                    
                    <a href="/whey_web/admin/users/add" class="btn btn-success" style="background-color: #2ECC71; border: none; padding: 10px 20px; font-weight: 600; border-radius: 8px; display: flex; align-items: center; gap: 8px;">
                        <span>➕</span> Thêm người dùng mới
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="padding: 15px;">HỌ TÊN</th>
                                <th>EMAIL</th>
                                <th>VAI TRÒ</th>
                                <th>TRẠNG THÁI</th>
                                <th class="text-center">HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="fw-bold" style="padding: 15px;"><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></td>
                                <td class="text-muted"><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge <?= ($user['role'] === 'admin') ? 'bg-primary-light text-primary' : 'bg-info-light text-info' ?>" 
                                          style="padding: 6px 12px; border-radius: 6px; text-transform: capitalize;">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <span class="badge bg-success-light text-success" style="padding: 6px 12px; border-radius: 6px;">Kích hoạt</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-light text-danger" style="padding: 6px 12px; border-radius: 6px;">Khóa</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/whey_web/admin/users/edit?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 4px;">Sửa</a>
                                        
                                        <?php if ($user['id'] !== ($_SESSION['user_id'] ?? '')): ?>
                                            <a href="/whey_web/admin/users/delete?id=<?= $user['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               style="border-radius: 4px;"
                                               onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                </div>
        </div>
    </div>
</div>

<style>
    /* Một chút CSS bổ sung để giống với giao diện của bạn */
    .bg-primary-light { background-color: #e7f1ff; }
    .bg-info-light { background-color: #e1f5fe; }
    .bg-success-light { background-color: #e8f5e9; }
    .bg-danger-light { background-color: #ffebee; }
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #888;
        border-bottom-width: 1px;
    }
</style>