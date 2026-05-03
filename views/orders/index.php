<div class="container" style="padding: 40px 20px; max-width: 1000px; margin: 0 auto;">
    <h2 style="margin-bottom: 30px;">Đơn hàng của tôi</h2>

    <?php if (empty($orders)): ?>
        <div style="text-align: center; padding: 50px; background: #f9f9f9; border-radius: 8px;">
            <p>Bạn chưa có đơn hàng nào.</p>
            <a href="/whey_web/products" style="color: #2563eb;">Mua sắm ngay</a>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 20px;">
            <?php foreach ($orders as $order): ?>
                <div class="card" style="padding: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #eee;">
                    <div>
                        <p style="font-weight: bold; margin-bottom: 5px;">Mã đơn: #<?= substr($order['id'], 0, 8) ?></p>
                        <p style="color: #666; font-size: 0.9rem;">Ngày đặt: <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-weight: bold; color: #2563eb; margin-bottom: 5px;">
                            <?= number_format($order['total_amount'], 0, ',', '.') ?>đ
                        </p>
                        <span style="font-size: 0.85rem; padding: 3px 10px; border-radius: 12px; 
                                     background: <?= $order['status'] === 'Cancelled' ? '#fee2e2' : '#e0f2fe' ?>;">
                            <?= $order['status'] ?>
                        </span>
                    </div>
                    <div>
                        <a href="/whey_web/orders/detail?id=<?= $order['id'] ?>" 
                           style="padding: 8px 15px; border: 1px solid #2563eb; color: #2563eb; text-decoration: none; border-radius: 4px;">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" style="padding: 5px 12px; border: 1px solid #ddd; <?= $i == $currentPage ? 'background: #2563eb; color: white;' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>