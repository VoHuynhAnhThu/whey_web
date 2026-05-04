<div class="admin-comments-container">
    <div class="admin-header">
        <h1>Quản lý Bình luận</h1>
    </div>

    <!-- Filter & Search Bar -->
    <div class="admin-filter">
        <div class="filter-group">
            <a href="/whey_web/admin/comments?status=all" class="filter-btn <?= $status === 'all' ? 'active' : '' ?>">
                Tất cả (<?= isset($total) ? $total : 0 ?>)
            </a>
            <a href="/whey_web/admin/comments?status=pending"
                class="filter-btn <?= $status === 'pending' ? 'active' : '' ?>">
                Chờ duyệt
            </a>
            <a href="/whey_web/admin/comments?status=approved"
                class="filter-btn <?= $status === 'approved' ? 'active' : '' ?>">
                Đã duyệt
            </a>
            <a href="/whey_web/admin/comments?status=rejected"
                class="filter-btn <?= $status === 'rejected' ? 'active' : '' ?>">
                Bị từ chối
            </a>
        </div>

        <form method="GET" action="/whey_web/admin/comments" class="search-form">
            <input type="hidden" name="status" value="<?= htmlspecialchars($status ?? 'all', ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-group">
                <input type="text" name="keyword" placeholder="Tìm kiếm theo tên, bài viết..."
                    value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control">
                <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <?php if (count($comments) > 0): ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Người dùng</th>
                        <th width="25%">Bài viết</th>
                        <th width="20%">Bình luận</th>
                        <th width="8%">Đánh giá</th>
                        <th width="10%">Trạng thái</th>
                        <th width="12%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = ($currentPage - 1) * 20 + 1; ?>
                    <?php foreach ($comments as $comment): ?>
                        <tr class="comment-row status-<?= $comment['status'] ?>">
                            <td><?= $i++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($comment['user_name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
                                <br>
                                <small><?= htmlspecialchars($comment['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></small>
                            </td>
                            <td>
                                <a href="/whey_web/admin/news?keyword=<?= urlencode($comment['news_title'] ?? '') ?>"
                                    target="_blank"
                                    title="<?= htmlspecialchars($comment['news_title'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars(substr($comment['news_title'] ?? 'N/A', 0, 40), ENT_QUOTES, 'UTF-8') ?>        <?= strlen($comment['news_title'] ?? '') > 40 ? '...' : '' ?>
                                </a>
                            </td>
                            <td>
                                <div class="comment-preview"
                                    title="<?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars(substr($comment['content'], 0, 60), ENT_QUOTES, 'UTF-8') ?>
                                    <?= strlen($comment['content']) > 60 ? '...' : '' ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if ($comment['rating'] > 0): ?>
                                    <span class="rating-stars">
                                        <?php for ($j = 1; $j <= $comment['rating']; $j++): ?>
                                            ★
                                        <?php endfor; ?>
                                    </span>
                                    <br>
                                    <small><?= $comment['rating'] ?>/5</small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= $comment['status'] ?>">
                                    <?php
                                    $statusLabels = [
                                        'pending' => 'Chờ duyệt',
                                        'approved' => 'Đã duyệt',
                                        'rejected' => 'Bị từ chối'
                                    ];
                                    ?>
                                    <?= $statusLabels[$comment['status']] ?? ucfirst($comment['status']) ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <?php if ($comment['status'] !== 'approved'): ?>
                                    <form method="POST" action="/whey_web/admin/comments/approve" class="inline-form">
                                        <input type="hidden" name="id"
                                            value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="btn btn-sm btn-success" title="Duyệt">✓</button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($comment['status'] !== 'rejected'): ?>
                                    <form method="POST" action="/whey_web/admin/comments/reject" class="inline-form">
                                        <input type="hidden" name="id"
                                            value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="btn btn-sm btn-warning" title="Từ chối">✗</button>
                                    </form>
                                <?php endif; ?>

                                <form method="POST" action="/whey_web/admin/comments/delete" class="inline-form">
                                    <input type="hidden" name="id"
                                        value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa?');">🗑</button>
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
                            <a
                                href="/whey_web/admin/comments?status=<?= $status ?>&page=1<?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                « Đầu
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/admin/comments?status=<?= $status ?>&page=<?= $currentPage - 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                ‹ Trước
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li <?= $i === $currentPage ? 'class="active"' : '' ?>>
                            <a
                                href="/whey_web/admin/comments?status=<?= $status ?>&page=<?= $i ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li>
                            <a
                                href="/whey_web/admin/comments?status=<?= $status ?>&page=<?= $currentPage + 1 ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                                Sau ›
                            </a>
                        </li>
                        <li>
                            <a
                                href="/whey_web/admin/comments?status=<?= $status ?>&page=<?= $totalPages ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
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
                Không tìm thấy bình luận nào với từ khoá "<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>".
            <?php elseif ($status !== 'all'): ?>
                Không có bình luận nào ở trạng thái này.
            <?php else: ?>
                Chưa có bình luận nào.
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .admin-comments-container {
        padding: 20px;
    }

    .admin-header {
        margin-bottom: 30px;
    }

    .admin-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
    }

    .admin-filter {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 20px;
        background-color: white;
        text-decoration: none;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .filter-btn:hover {
        background-color: #e9e9e9;
    }

    .filter-btn.active {
        background-color: #0066cc;
        color: white;
        border-color: #0066cc;
    }

    .search-form {
        display: flex;
        gap: 10px;
    }

    .search-form .form-group {
        flex: 1;
        display: flex;
        gap: 10px;
        margin: 0;
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

    .comment-row.status-pending {
        background-color: #fff8dc;
    }

    .comment-row.status-approved {
        background-color: #f0fff4;
    }

    .comment-row.status-rejected {
        background-color: #fff5f5;
    }

    .comment-preview {
        max-width: 300px;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #666;
        font-size: 0.9rem;
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #999;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 1.1rem;
        letter-spacing: 2px;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: bold;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-approved {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .inline-form {
        display: inline;
    }

    .btn {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 0.85rem;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #333;
    }

    .btn-warning:hover {
        background-color: #e0a800;
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

    .form-control:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.2);
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

    @media (max-width: 768px) {
        .admin-filter {
            padding: 15px;
        }

        .filter-group {
            gap: 5px;
        }

        .filter-btn {
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        .search-form {
            flex-direction: column;
        }

        .search-form .form-group {
            flex-direction: column;
        }

        .action-buttons {
            gap: 3px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 0.75rem;
        }
    }
</style>