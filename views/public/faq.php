<?php
/** @var array $questions */ 
?>

<link rel="stylesheet" href="/whey_web/assets/css/faq-public.css">

<div class="faq-container">
    <section class="ask-form card">
        <h3>Đặt câu hỏi mới</h3>
        <form action="/whey_web/faq/ask" method="POST">
            <div class="form-group">
                <input type="text" name="title" placeholder="Tiêu đề câu hỏi..." required class="form-control">
            </div>
            <div class="form-group">
                <textarea name="body" placeholder="Nội dung thắc mắc của bạn..." required class="form-control"></textarea>
            </div>
            <button type="submit" class="btn-save">Gửi câu hỏi</button>
        </form>
    </section>

    <div class="faq-list">
        <h2 class="list-title">Câu hỏi thường gặp</h2>
        <?php foreach($questions as $q): ?>
            <div class="faq-item card">
               <div class="question-header">
                <span class="q-badge">Q</span>
                <div>
                    <h4><?= htmlspecialchars($q['title']) ?></h4>
                    <small class="questioner-info">
                        Bởi: <strong><?= htmlspecialchars($q['questioner_name'] ?? 'Khách vãng lai') ?></strong> 
                        • <?= date('d/m/Y', strtotime($q['created_at'])) ?>
                    </small>
                </div>
            </div>
                <p class="question-body"><?= htmlspecialchars($q['body']) ?></p>
                
                <?php if($q['answer_body']): ?>
                    <div class="admin-reply">
                        <div class="reply-header">
                            <span class="a-badge">A</span>
                            <strong>FITWHEY phản hồi:</strong>
                        </div>
                        <div class="reply-content">
                            <?= nl2br(htmlspecialchars($q['answer_body'])) ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="waiting-reply">
                        <small>🕒 Đang chờ phản hồi từ chuyên gia...</small>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>