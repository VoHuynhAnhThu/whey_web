<?php include __DIR__ . '/../header.php'; ?>

<style>
    /* Tổng thể Card */
    .fit-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
    .fit-header { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 25px 30px; }
    .fit-title { font-weight: 800; color: #1a1a1a; margin: 0; font-family: 'Inter', sans-serif; }
    
    /* Bảng dữ liệu hiện đại */
    .fit-table-container { padding: 0 20px 20px 20px; }
    .fit-table { border-collapse: separate; border-spacing: 0 12px; width: 100%; }
    .fit-table thead th { border: none; color: #9ca3af; font-size: 0.8rem; letter-spacing: 1px; padding: 10px 20px; }
    .fit-table tbody tr { transition: all 0.3s ease; }
    .fit-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
    .fit-table td { background: #fff; border-top: 1px solid #f9fafb; border-bottom: 1px solid #f9fafb; padding: 20px !important; vertical-align: middle !important; }
    .fit-table td:first-child { border-left: 1px solid #f9fafb; border-radius: 15px 0 0 15px; }
    .fit-table td:last-child { border-right: 1px solid #f9fafb; border-radius: 0 15px 15px 0; }

    /* Badge trạng thái bo tròn xịn */
    .badge-pill-fit { padding: 6px 16px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; border: none; }
    .status-unread { background: #fee2e2; color: #ef4444; }
    .status-read { background: #fef3c7; color: #f59e0b; }
    .status-replied { background: #dcfce7; color: #10b981; }

    /* Nút hành động */
    .btn-action { width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; background: #f3f4f6; color: #4b5563; }
    .btn-action:hover { background: #10b981; color: #fff; transform: rotate(10deg); }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* Phân trang */
    .pagination .page-link { border: none; margin: 0 5px; border-radius: 10px; color: #4b5563; font-weight: 600; }
    .pagination .page-item.active .page-link { background: #10b981; color: #fff; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
</style>

<div class="row mt-5">
    <div class="col-12">
        <div class="fit-card">
            <div class="fit-header d-flex justify-content-between align-items-center">
                <h4 class="fit-title">Quản lý liên hệ - <span style="color: #10b981;">FITWHEY</span></h4>
                <span class="badge bg-light text-dark border p-2">Tổng: <?php echo count($contacts); ?></span>
            </div>
            
            <div class="fit-table-container">
                <div class="table-responsive">
                    <table class="fit-table text-center">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Khách hàng</th>
                                <th>Thông tin</th>
                                <th>Nội dung lời nhắn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td class="text-left">
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($contact['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <small class="text-muted"><i class="ti-time mr-1"></i><?php echo date('H:i d/m/Y', strtotime($contact['created_at'])); ?></small>
                                </td>
                                <td class="text-left small">
                                    <div class="mb-1"><i class="ti-email mr-2 text-success"></i><?php echo htmlspecialchars($contact['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div><i class="ti-mobile mr-2 text-success"></i><?php echo htmlspecialchars($contact['phone'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></div>
                                </td>
                                <td class="text-left" style="max-width: 350px;">
                                    <div class="fw-bold mb-1"><?php echo htmlspecialchars($contact['subject'] ?? 'Không có tiêu đề', ENT_QUOTES, 'UTF-8'); ?></div>
                                    <p class="text-muted small mb-0 text-truncate" title="<?php echo htmlspecialchars($contact['message'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($contact['message'], ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </td>
                                <td>
                                    <?php 
                                    $status = trim($contact['status'] ?? 'unread'); 
                                    if ($status === 'unread'): ?>
                                        <span class="badge-pill-fit status-unread">Chưa đọc</span>
                                    <?php elseif ($status === 'read'): ?>
                                        <span class="badge-pill-fit status-read">Đã đọc</span>
                                    <?php else: ?>
                                        <span class="badge-pill-fit status-replied">Đã phản hồi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="/whey_web/admin/contacts/update-status" method="POST">
                                            <input type="hidden" name="id" value="<?php echo (string)$contact['id']; ?>">
                                            <input type="hidden" name="status" value="replied">
                                            <button type="submit" class="btn-action" title="Đánh dấu đã phản hồi">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="/whey_web/admin/contacts/delete" method="POST" onsubmit="return confirm('Xóa liên hệ này?')">
                                            <input type="hidden" name="id" value="<?php echo (string)$contact['id']; ?>">
                                            <button type="submit" class="btn-action btn-delete" title="Xóa">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link shadow-sm" href="?page=<?php echo $currentPage - 1; ?>"><i class="ti-arrow-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link shadow-sm" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link shadow-sm" href="?page=<?php echo $currentPage + 1; ?>"><i class="ti-arrow-right"></i></a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>