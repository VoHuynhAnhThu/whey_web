<div class="news-container">
    <h1>Tin Tức</h1>

    <div class="news-search">
        <form method="GET" action="/whey_web/news">
            <div class="form-group">
                <input type="text" name="keyword" placeholder="Tìm kiếm bài viết..."
                    value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </form>
    </div>

    <?php if (count($news) > 0): ?>
        <div class="news-list">
            <?php foreach ($news as $article): ?>
                <div class="news-item">
                    <div class="news-item-header">
                        <h2 class="news-title">
                            <a href="/whey_web/news/detail?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h2>
                    </div>

                    <?php if (!empty($article['featured_image'])): ?>
                        <div class="news-featured-image">
                            <img src="<?= htmlspecialchars($article['featured_image'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>" class="img-responsive">
                        </div>
                    <?php endif; ?>

                    <div class="news-description">
                        <p><?= htmlspecialchars($article['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <div class="news-meta">
                        <span class="meta-author">
                            Tác giả: <?= htmlspecialchars($article['author_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <span class="meta-date">
                            <?= date('d/m/Y H:i', strtotime($article['created_at'])) ?>
                        </span>
                        <span class="meta-views">
                            👁 <?= number_format($article['view_count']) ?> lượt xem
                        </span>
                    </div>

                    <div class="news-action">
                        <a href="/whey_web/news/detail?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') ?>"
                            class="btn btn-secondary">
                            Đọc tiếp
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <ul>
                    <?php if ($currentPage > 1): ?>
                        <li>
                            <a href="/whey_web/news?page=1<?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                « Trang đầu
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/news?page=<?= $currentPage - 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                ‹ Trang trước
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li <?= $i === $currentPage ? 'class="active"' : '' ?>>
                            <a href="/whey_web/news?page=<?= $i ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li>
                            <a
                                href="/whey_web/news?page=<?= $currentPage + 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Trang sau ›
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/news?page=<?= $totalPages ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Trang cuối »
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <?php if (!empty($keyword)): ?>
                Không tìm thấy bài viết nào với từ khoá "<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>".
            <?php else: ?>
                Chưa có bài viết nào.
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .news-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .news-container h1 {
        font-size: 2rem;
        margin-bottom: 30px;
        color: #333;
    }

    .news-search {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .news-list {
        display: grid;
        gap: 30px;
    }

    .news-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        transition: box-shadow 0.3s ease;
    }

    .news-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .news-item-header {
        margin-bottom: 15px;
    }

    .news-title {
        font-size: 1.5rem;
        margin: 0;
    }

    .news-title a {
        color: #0066cc;
        text-decoration: none;
    }

    .news-title a:hover {
        text-decoration: underline;
    }

    .news-featured-image {
        margin: 15px 0;
        max-height: 300px;
        overflow: hidden;
        border-radius: 4px;
    }

    .news-featured-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .news-description {
        color: #666;
        line-height: 1.6;
        margin: 15px 0;
    }

    .news-meta {
        display: flex;
        gap: 20px;
        font-size: 0.9rem;
        color: #999;
        margin: 15px 0;
        flex-wrap: wrap;
    }

    .news-meta span {
        display: inline-block;
    }

    .news-action {
        margin-top: 15px;
    }

    .pagination {
        margin-top: 40px;
        text-align: center;
    }

    .pagination ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #0066cc;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background-color: #0066cc;
        color: white;
    }

    .pagination li.active a {
        background-color: #0066cc;
        color: white;
        border-color: #0066cc;
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

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
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

    @media (max-width: 768px) {
        .news-container h1 {
            font-size: 1.5rem;
        }

        .news-title {
            font-size: 1.2rem;
        }

        .news-meta {
            flex-direction: column;
            gap: 5px;
        }
    }
</style>