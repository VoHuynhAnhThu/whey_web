<?php
/** @var array $question */
?>
<link rel="stylesheet" href="/whey_web/assets/css/about.css">

<link rel="stylesheet" href="/whey_web/assets/css/faq-admin.css">

<div class="admin-container">
    <h1>Phản hồi câu hỏi</h1>
    
    <div class="card faq-preview-card">
        <strong>Câu hỏi từ khách hàng:</strong>
        <p class="question-content">
            <em>"<?= htmlspecialchars($question['body'] ?? 'Không có nội dung') ?>"</em>
        </p>
    </div>

    <form action="/whey_web/admin/faqs/reply" method="POST" class="faq-reply-form">
        <input type="hidden" name="question_id" value="<?= htmlspecialchars($question['id'] ?? '') ?>">
        
        <div class="form-group">
            <label>Nội dung câu trả lời:</label>
            <textarea name="answer_body" rows="6" class="form-control" required placeholder="Nhập câu trả lời tại đây..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Gửi phản hồi</button>
            <a href="/whey_web/admin/faqs" class="btn-cancel">Hủy bỏ</a>
        </div>
    </form>
</div>