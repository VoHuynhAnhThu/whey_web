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
                                    <strong><?php echo $contact['full_name']; ?></strong><br>
                                    <small><?php echo $contact['created_at']; ?></small>
                                </td>
                                <td>
                                    <?php echo $contact['email']; ?><br>
                                    <?php echo $contact['phone']; ?>
                                </td>
                                <td class="text-left" style="max-width: 300px;">
                                    <strong><?php echo $contact['subject']; ?></strong><br>
                                    <span class="text-muted"><?php echo $contact['message']; ?></span>
                                </td>
                                <td>
                                    <?php 
    // Dùng trim() để tránh khoảng trắng dư thừa trong DB
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
                                                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                                <input type="hidden" name="status" value="replied">
                                                <button type="submit" class="text-secondary" title="Đánh dấu đã phản hồi" style="border:none; background:none;"><i class="fa fa-check-circle"></i></button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="/whey_web/admin/contacts/delete" method="POST" onsubmit="return confirm('Xóa liên hệ này?')">
                                                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                                <button type="submit" class="text-danger" style="border:none; background:none;"><i class="ti-trash"></i></button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>