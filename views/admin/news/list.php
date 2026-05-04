<div class="admin-news-container">
    <div class="admin-header">
        <h1>Quản lý Tin tức</h1>
        <a href="/whey_web/admin/news/create" class="btn btn-primary">+ Tạo bài viết mới</a>
    </div>

    <!-- Search Bar -->
    <div class="admin-search">
        <form method="GET" action="/whey_web/admin/news">
            <div class="form-group">
                <input type="text" name="keyword" placeholder="Tìm kiếm bài viết..."
                    value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control">
                <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <?php if (count($news) > 0): ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="30%">Tiêu đề</th>
                        <th width="15%">Tác giả</th>
                        <th width="10%">Trạng thái</th>
                        <th width="12%">Ngày tạo</th>
                        <th width="10%">Lượt xem</th>
                        <th width="18%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = ($currentPage - 1) * 10 + 1; ?>
                    <?php foreach ($news as $article): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="text-truncate">
                                <a href="/whey_web/news/detail?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') ?>"
                                    target="_blank">
                                    <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($article['author_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <span class="badge badge-<?= $article['status'] === 'published' ? 'success' : 'warning' ?>">
                                    <?= ucfirst($article['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></td>
                            <td><?= number_format($article['view_count']) ?></td>
                            <td class="action-buttons">
                                <a href="/whey_web/admin/news/edit?id=<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="btn btn-sm btn-info">Sửa</a>
                                <form method="POST" action="/whey_web/admin/news/delete" class="delete-form"
                                    style="display: inline;">
                                    <input type="hidden" name="id"
                                        value="<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <ul>
                    <?php if ($currentPage > 1): ?>
                        <li>
                            <a href="/whey_web/admin/news?page=1<?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                « Trang đầu
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/admin/news?page=<?= $currentPage - 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                ‹ Trang trước
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li <?= $i === $currentPage ? 'class="active"' : '' ?>>
                            <a
                                href="/whey_web/admin/news?page=<?= $i ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li>
                            <a
                                href="/whey_web/admin/news?page=<?= $currentPage + 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Trang sau ›
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/admin/news?page=<?= $totalPages ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
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
                Chưa có bài viết nào. <a href="/whey_web/admin/news/create">Tạo bài viết đầu tiên</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .admin-news-container {
        padding: 20px;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .admin-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
    }

    .admin-search {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .table-responsive {
        background-color: #fff;
        border-radius: 8px;
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table thead {
        background-color: #f9f9f9;
        border-bottom: 2px solid #ddd;
    }

    .admin-table th {
        padding: 15px;
        text-align: left;
        font-weight: bold;
        color: #333;
    }

    .admin-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .admin-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .admin-table a {
        color: #0066cc;
        text-decoration: none;
    }

    .admin-table a:hover {
        text-decoration: underline;
    }

    .text-truncate {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: bold;
    }

    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 0.9rem;
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

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
    }

    .btn-info {
        background-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group {
        display: flex;
        gap: 10px;
    }

    .form-group input {
        flex: 1;
    }

    .pagination {
        text-align: center;
        margin-top: 30px;
    }

    .pagination ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .pagination a {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #0066cc;
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

    .alert-info a {
        color: #0c5460;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .form-group {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>