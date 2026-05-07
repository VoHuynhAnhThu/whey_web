<?php
?>
<div class="news-container">
    <div class="news-header">
        <h1>Tin Tức & Hướng Dẫn</h1>
        <a href="/whey_web/news" class="view-all-btn">XEM TẤT CẢ</a>
    </div>

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
        <div class="news-grid">
            <?php foreach ($news as $article): ?>
                <div class="news-card">
                    <!-- Badges -->
                    <div class="card-badges">
                        <?php 
                            $createdDate = strtotime($article['created_at']);
                            $daysOld = (time() - $createdDate) / (60 * 60 * 24);
                            
                            if ($daysOld < 7): ?>
                                <span class="badge badge-new">NEW</span>
                            <?php endif; ?>
                            
                            <?php if ($article['view_count'] > 100): ?>
                                <span class="badge badge-hot">HOT</span>
                            <?php endif; ?>
                            
                            <?php if (($article['status'] ?? '') === 'draft'): ?>
                                <span class="badge badge-locked">LOCKED</span>
                            <?php endif; ?>
                    </div>

                    <!-- Featured Image -->
                    <div class="card-image">
                        <?php if (!empty($article['featured_image'])): ?>
                            <img src="<?= htmlspecialchars($article['featured_image'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php else: ?>
                            <div class="image-placeholder">
                                <svg viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="200" height="150" fill="#e0e0e0"/>
                                    <circle cx="60" cy="50" r="15" fill="#999"/>
                                    <polygon points="10,150 70,80 130,130 200,70 200,150" fill="#999"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Content -->
                    <div class="card-content">
                        <h3 class="card-title">
                            <a href="/whey_web/news/detail?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>

                        <p class="card-description">
                            <?= htmlspecialchars(substr($article['description'] ?? '', 0, 100), ENT_QUOTES, 'UTF-8') ?>
                            <?= strlen($article['description'] ?? '') > 100 ? '...' : '' ?>
                        </p>

                        <div class="card-meta">
                            <span class="meta-date">📅 <?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                            <span class="meta-author">👤 <?= htmlspecialchars($article['author_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>

                        <div class="card-footer">
                            <span class="view-count">👁 <?= number_format($article['view_count']) ?></span>
                            <a href="/whey_web/news/detail?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') ?>" class="read-more">Đọc tiếp →</a>
                        </div>
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
                                « Đầu
                            </a>
                        </li>
                        <li>
                            <a href="/whey_web/news?page=<?= $currentPage - 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                ‹ Trước
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
                            <a href="/whey_web/news?page=<?= $currentPage + 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Sau ›
                            </a>
                        </li>
                        <li>
                            <a href="/whey_web/news?page=<?= $totalPages ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Cuối »
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
    :root {
        --primary-color: #28a745;
        --dark-color: #333333;
        --gray-light: #f5f5f5;
        --gray-border: #ddd;
        --transition: all 0.3s ease;
    }

    .news-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .news-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 3px solid var(--primary-color);
    }

    .news-header h1 {
        margin: 0;
        font-size: 2.5rem;
        color: var(--dark-color);
        font-weight: 900;
    }

    .view-all-btn {
        background-color: var(--dark-color);
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .view-all-btn:hover {
        background-color: var(--primary-color);
    }

    .news-search {
        background-color: var(--gray-light);
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 40px;
    }

    .news-search .form-group {
        display: flex;
        gap: 10px;
    }

    .news-search .form-control {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid var(--gray-border);
        border-radius: 4px;
        font-size: 1rem;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-bottom: 50px;
    }

    .news-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .news-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .card-badges {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        z-index: 10;
    }

    .card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background-color: #f0f0f0;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .news-card:hover .card-image img {
        transform: scale(1.05);
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
    }

    .image-placeholder svg {
        width: 80%;
        height: 80%;
    }

    .card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        margin: 0 0 12px 0;
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.4;
    }

    .card-title a {
        color: var(--dark-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .card-title a:hover {
        color: var(--primary-color);
    }

    .card-description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0 0 15px 0;
        flex: 1;
    }

    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }

    .view-count {
        color: #999;
        font-size: 0.85rem;
    }

    .read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .read-more:hover {
        color: var(--dark-color);
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    .badge-new {
        background-color: #28a745;
        color: white;
    }

    .badge-hot {
        background-color: #dc3545;
        color: white;
    }

    .badge-locked {
        background-color: #6c757d;
        color: white;
    }

    .pagination {
        text-align: center;
        margin-top: 40px;
    }

    .pagination ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination a {
        display: inline-block;
        padding: 10px 14px;
        border: 1px solid var(--gray-border);
        border-radius: 4px;
        text-decoration: none;
        color: var(--primary-color);
        transition: var(--transition);
        font-weight: 500;
    }

    .pagination a:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination li.active a {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .alert {
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin: 40px 0;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: var(--transition);
        font-size: 1rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: #218838;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--gray-border);
        border-radius: 4px;
        font-size: 1rem;
    }

        /* Responsive Design */
    @media (max-width: 1024px) {
        .news-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .news-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .news-header h1 {
            font-size: 1.8rem;
        }

        .card-image {
            height: 180px;
        }

        .card-content {
            padding: 15px;
        }

        .card-title {
            font-size: 1rem;
        }

        .news-search .form-group {
            flex-direction: column;
        }

        .news-container {
            padding: 20px 15px;
        }
    }
</style>