<?php
/** @var array $questions */ 
?>

<link rel="stylesheet" href="/whey_web/assets/css/about.css">

<div class="admin-container">
    <h1>Quản lý câu hỏi (FAQ)</h1>
    
    <table class="admin-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 12px; text-align: left;">Câu hỏi</th>
                <th style="padding: 12px; text-align: left;">Trạng thái</th>
                <th style="padding: 12px; text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $q): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">
                        <strong><?= htmlspecialchars($q['title']) ?></strong>
                        <p style="font-size: 0.85rem; color: #666;"><?= htmlspecialchars($q['body']) ?></p>
                    </td>
                    <td style="padding: 12px;">
                        <?php if ($q['answer_body']): ?>
                            <span style="color: #27ae60;">✔ Đã trả lời</span>
                        <?php else: ?>
                            <span style="color: #e67e22;">⏳ Đang chờ</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <!-- Nút dẫn tới trang trả lời -->
                        <a href="/whey_web/admin/faqs/reply?id=<?= $q['id'] ?>" class="btn-save" style="text-decoration: none; font-size: 0.8rem; padding: 8px 12px;">Trả lời</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>