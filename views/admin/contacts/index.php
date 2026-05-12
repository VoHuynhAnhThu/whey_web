<?php include __DIR__ . '/../header.php'; ?>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Danh sách liên hệ từ khách hàng</h4>
                <div class="table-responsive">
                    <table class="table table-hover progress-table text-center">
                        <thead class="text-uppercase">
                            <tr>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Thông tin</th>
                                <th scope="col">Lời nhắn</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td>
                                    <!-- Dùng htmlspecialchars để chống chèn mã độc JS -->
                                    <strong><?php echo htmlspecialchars($contact['name'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                                    <small><?php echo htmlspecialchars($contact['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($contact['email'], ENT_QUOTES, 'UTF-8'); ?><br>
                                    <?php echo htmlspecialchars($contact['phone'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="text-left" style="max-width: 300px;">
                                    <strong><?php echo htmlspecialchars($contact['subject'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                                    <span class="text-muted"><?php echo htmlspecialchars($contact['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </td>
                                <td>
                                    <?php 
                                    $status = trim($contact['status'] ?? 'unread'); 
                                    if ($status === 'unread'): ?>
                                        <span class="badge" style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 4px;">Chưa đọc</span>
                                    <?php elseif ($status === 'read'): ?>
                                        <span class="badge" style="background-color: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 4px;">Đã đọc</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 4px;">Đã phản hồi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="mr-3">
                                            <form action="/whey_web/admin/contacts/update-status" method="POST">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$contact['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <input type="hidden" name="status" value="replied">
                                                <button type="submit" class="text-secondary" title="Đánh dấu đã phản hồi" style="border:none; background:none;"><i class="fa fa-check-circle"></i></button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="/whey_web/admin/contacts/delete" method="POST" onsubmit="return confirm('Xóa liên hệ này?')">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$contact['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <button type="submit" class="text-danger" style="border:none; background:none;"><i class="ti-trash"></i></button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                </div> <!-- End table-responsive -->

                <!-- BẮT ĐẦU: KHỐI PHÂN TRANG -->
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        
                        <!-- Nút "Trang trước" (Ẩn nếu đang ở trang 1) -->
                        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Trước</a>
                        </li>

                        <!-- Vòng lặp vẽ các nút trang 1, 2, 3... -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Nút "Trang sau" (Ẩn nếu đang ở trang cuối cùng) -->
                        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Sau</a>
                        </li>
                        
                    </ul>
                </nav>
                <?php endif; ?>
                <!-- KẾT THÚC: KHỐI PHÂN TRANG -->

            </div> <!-- End card-body -->
        </div> <!-- End card -->
    </div> <!-- End col-12 -->
</div> <!-- End row -->     
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>