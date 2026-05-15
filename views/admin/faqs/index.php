<?php
/** @var array $questions */ 
?>

<link rel="stylesheet" href="/whey_web/assets/css/about.css">

<div class="admin-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 1.5rem; color: #333;">Quản lý câu hỏi (FAQ)</h1>
        
        <a href="/whey_web/admin/faqs/create" class="btn-save" style="background-color: #2ECC71; color: white; text-decoration: none; padding: 10px 16px; border-radius: 6px; font-weight: 600; display: flex; align-items: center; gap: 8px; border: none;">
            <span>➕</span> Thêm câu hỏi mới
        </a>
    </div>
    
    <table class="admin-table" style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #555;">Câu hỏi</th>
                <th style="padding: 15px; text-align: center; font-weight: 600; color: #555;">Trạng thái</th>
                <th style="padding: 15px; text-align: center; font-weight: 600; color: #555;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $q): ?>
                    <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;">
                        <td style="padding: 15px;">
                            <strong style="color: #333; font-size: 1.05rem;"><?= htmlspecialchars($q['title'] ?? 'Không có tiêu đề') ?></strong>
                            <p style="font-size: 0.9rem; color: #666; margin-top: 6px; margin-bottom: 0;">
                                <?= htmlspecialchars($q['body'] ?? '') ?>
                            </p>
                        </td>
                        
                        <td style="padding: 15px; text-align: center; vertical-align: middle;">
                            <?php if (!empty($q['answer_body'])): ?>
                                <span style="background-color: #e8f5e9; color: #27ae60; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">✔ Đã trả lời</span>
                            <?php else: ?>
                                <span style="background-color: #fff3e0; color: #e67e22; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">⏳ Đang chờ</span>
                            <?php endif; ?>
                        </td>
                        
                        <td style="padding: 15px; text-align: center; vertical-align: middle;">
                            <div style="display: flex; justify-content: center; gap: 10px;">
                                <a href="/whey_web/admin/faqs/reply?id=<?= $q['id'] ?>" 
                                   style="background-color: #e7f1ff; color: #0d6efd; border: 1px solid #0d6efd; text-decoration: none; font-size: 0.85rem; padding: 6px 12px; border-radius: 4px;">
                                   Sửa / Trả lời
                                </a>
                                
                                <a href="/whey_web/admin/faqs/delete?id=<?= $q['id'] ?>" 
                                   style="background-color: #ffebee; color: #dc3545; border: 1px solid #dc3545; text-decoration: none; font-size: 0.85rem; padding: 6px 12px; border-radius: 4px;"
                                   onclick="return confirm('Bạn chắc chắn muốn xóa câu hỏi này chứ?')">
                                   Xóa
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="padding: 30px; text-align: center; color: #888;">
                        Chưa có câu hỏi nào trong hệ thống.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>