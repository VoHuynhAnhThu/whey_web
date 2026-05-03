<div class="card" style="margin: 20px; padding: 20px;">
    <h2>Quản lý đơn hàng</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Khách hàng</th>
                <th style="padding: 10px;">Tổng tiền</th>
                <th style="padding: 10px;">Ngày đặt</th>
                <th style="padding: 10px;">Trạng thái</th>
                <th style="padding: 10px;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px;">
                    <strong><?= htmlspecialchars($order['full_name']) ?></strong><br>
                    <small><?= htmlspecialchars($order['email']) ?></small>
                </td>
                <td style="padding: 10px; color: var(--primary); font-weight: bold;">
                    <?= number_format($order['total_amount'], 0, ',', '.') ?>đ
                </td>
                <td style="padding: 10px;"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                <td style="padding: 10px;">
                    <span class="badge-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
                </td>
                <td style="padding: 10px;">
                    <form action="/whey_web/admin/orders/update-status" method="post">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Đang giao</option>
                            <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Hủy bỏ</option>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">&laquo;</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" 
               style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; 
                      <?= $i === $currentPage ? 'background: #2563eb; color: white; border-color: #2563eb;' : 'color: #333;' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">&raquo;</a>
        <?php endif; ?>
    </div>
</div>