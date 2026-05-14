<div class="news-detail-container">
    <?php if (!empty($news['featured_image'])): ?>
        <div class="featured-image">
            <img src="<?= htmlspecialchars($news['featured_image'], ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($news['title'], ENT_QUOTES, 'UTF-8') ?>" class="img-responsive">
        </div>
    <?php endif; ?>

    <article class="news-article">
        <header class="article-header">
            <h1 class="article-title">
                <?= htmlspecialchars($news['title'], ENT_QUOTES, 'UTF-8') ?>
            </h1>

            <div class="article-meta">
                <span class="meta-author">
                    Tác giả:
                    <strong><?= htmlspecialchars($news['author_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></strong>
                </span>
                <span class="meta-date">
                    📅 <?= date('d/m/Y H:i', strtotime($news['created_at'])) ?>
                </span>
                <?php if (!empty($news['updated_at']) && $news['updated_at'] !== $news['created_at']): ?>
                    <span class="meta-updated">
                        (Cập nhật: <?= date('d/m/Y H:i', strtotime($news['updated_at'])) ?>)
                    </span>
                <?php endif; ?>
                <span class="meta-views">
                    👁 <?= number_format($news['view_count']) ?> lượt xem
                </span>
            </div>

            <?php if (!empty($news['description'])): ?>
                <div class="article-description">
                    <p><?= htmlspecialchars($news['description'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php endif; ?>
        </header>

        <div class="article-content">
            <?= $news['content'] ?>
        </div>

        <footer class="article-footer">
            <a href="/whey_web/news" class="btn btn-secondary">← Quay lại danh sách</a>
        </footer>
    </article>

    <!-- Comments Section -->
    <section class="comments-section">
        <h2>Bình luận & Đánh giá (<?= $totalComments ?>)</h2>

        <!-- Comments List -->
        <?php if (count($comments) > 0): ?>
            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="comment-header">
                            <div class="comment-author">
                                <?php if (!empty($comment['user_avatar'])): ?>
                                    <img src="<?= htmlspecialchars($comment['user_avatar'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($comment['user_name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?>"
                                        class="comment-avatar">
                                <?php else: ?>
                                    <div class="comment-avatar-placeholder">?</div>
                                <?php endif; ?>
                                <div class="author-info">
                                    <strong><?= htmlspecialchars($comment['user_name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
                                    <div class="comment-date">
                                        <?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($comment['rating'] > 0): ?>
                                <div class="comment-rating">
                                    <span class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star <?= $i <= $comment['rating'] ? 'filled' : 'empty' ?>">★</span>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="rating-text"><?= $comment['rating'] ?>/5</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="comment-content">
                            <?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Comments Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="comments-pagination">
                    <ul>
                        <?php if ($currentPage > 1): ?>
                            <li>
                                <a
                                    href="/whey_web/news/detail?slug=<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>&page=1">
                                    « Đầu
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/whey_web/news/detail?slug=<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>&page=<?= $currentPage - 1 ?>">
                                    ‹ Trước
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li <?= $i === $currentPage ? 'class="active"' : '' ?>>
                                <a
                                    href="/whey_web/news/detail?slug=<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>&page=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li>
                                <a
                                    href="/whey_web/news/detail?slug=<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>&page=<?= $currentPage + 1 ?>">
                                    Sau ›
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/whey_web/news/detail?slug=<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>&page=<?= $totalPages ?>">
                                    Cuối »
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">
                Chưa có bình luận nào. Hãy là người đầu tiên!
            </div>
        <?php endif; ?>

        <!-- Add Comment Form -->
        <?php if (Auth::check()): ?>
            <div class="comment-form">
                <h3>Viết bình luận của bạn</h3>
                <form method="POST" action="/whey_web/news/comment">
                    <input type="hidden" name="news_id" value="<?= htmlspecialchars($news['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="slug" value="<?= htmlspecialchars($news['slug'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="form-group">
                        <label for="rating">Đánh giá:</label>
                        <select id="rating" name="rating" class="form-control">
                            <option value="0">-- Không đánh giá --</option>
                            <option value="1">⭐ (1 sao)</option>
                            <option value="2">⭐⭐ (2 sao)</option>
                            <option value="3">⭐⭐⭐ (3 sao)</option>
                            <option value="4">⭐⭐⭐⭐ (4 sao)</option>
                            <option value="5">⭐⭐⭐⭐⭐ (5 sao)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="content">Bình luận:</label>
                        <textarea id="content" name="content" class="form-control" rows="6"
                            placeholder="Chia sẻ suy nghĩ của bạn..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    <p class="form-note">
                        Bình luận của bạn sẽ được kiểm duyệt trước khi hiển thị.
                    </p>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <p>Vui lòng <a href="/whey_web/login">đăng nhập</a> để viết bình luận.</p>
            </div>
        <?php endif; ?>
    </section>
</div>

<style>
    .news-detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .featured-image {
        margin: -20px -20px 30px -20px;
        height: 400px;           /* hoặc 500px theo thiết kế */
        overflow: hidden;
    }

    .featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .news-article {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 40px;
    }

    .article-header {
        border-bottom: 2px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .article-title {
        font-size: 2rem;
        margin: 0 0 15px 0;
        color: #333;
    }

    .article-meta {
        display: flex;
        gap: 20px;
        font-size: 0.9rem;
        color: #666;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .meta-author strong {
        color: #0066cc;
    }

    .article-description {
        font-size: 1.1rem;
        color: #555;
        font-style: italic;
        margin-top: 15px;
        padding: 15px;
        background-color: #f9f9f9;
        border-left: 3px solid #0066cc;
    }

    .article-content {
        font-size: 1rem;
        line-height: 1.8;
        color: #444;
        margin: 30px 0;
    }

    .article-footer {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Comments Section */
    .comments-section {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        margin-top: 40px;
    }

    .comments-section h2 {
        font-size: 1.5rem;
        margin-bottom: 30px;
        color: #333;
    }

    .comments-list {
        margin-bottom: 40px;
    }

    .comment-item {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        border-left: 3px solid #0066cc;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .comment-author {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .comment-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .comment-avatar-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #666;
    }

    .author-info strong {
        display: block;
        margin-bottom: 5px;
    }

    .comment-date {
        font-size: 0.85rem;
        color: #999;
    }

    .comment-rating {
        text-align: right;
    }

    .stars {
        font-size: 1.2rem;
        letter-spacing: 2px;
    }

    .star.filled {
        color: #ffc107;
    }

    .star.empty {
        color: #ddd;
    }

    .rating-text {
        display: block;
        font-size: 0.9rem;
        color: #666;
        margin-top: 5px;
    }

    .comment-content {
        color: #555;
        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .comments-pagination {
        text-align: center;
        margin: 30px 0;
    }

    .comments-pagination ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .comments-pagination a {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #0066cc;
    }

    .comments-pagination a:hover {
        background-color: #0066cc;
        color: white;
    }

    .comments-pagination li.active a {
        background-color: #0066cc;
        color: white;
        border-color: #0066cc;
    }

    /* Comment Form */
    .comment-form {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        margin-top: 30px;
    }

    .comment-form h3 {
        font-size: 1.3rem;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.2);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .form-note {
        font-size: 0.9rem;
        color: #999;
        margin-top: 10px;
        margin-bottom: 0;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
        font-size: 1rem;
    }

    .btn-primary {
        background-color: #0066cc;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0052a3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .alert-info a {
        color: #0c5460;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .news-detail-container {
            padding: 15px;
        }

        .news-article {
            padding: 20px;
        }

        .article-title {
            font-size: 1.5rem;
        }

        .article-meta {
            flex-direction: column;
            gap: 5px;
        }

        .comment-header {
            flex-direction: column;
        }

        .comment-rating {
            text-align: left;
            margin-top: 10px;
        }
    }
</style>