<div class="container" style="padding: 40px 20px;">
    <h2>Chi tiết đơn hàng #<?= substr($order['id'], 0, 8) ?></h2>
    <p>Trạng thái: <strong><?= $order['status'] ?></strong></p>
    <p>Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f4f4f4; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">Sản phẩm</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Giá</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Số lượng</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;">
                <?php 
                    // Kiểm tra nếu url không trống thì nối đường dẫn, ngược lại dùng ảnh mặc định
                    $imagePath = !empty($item['url']) 
                                ? "/whey_web/" . $item['url'] 
                                : "/whey_web/default-product.png";
                ?>
                <img src="<?= $imagePath ?>" 
                    width="50" 
                    style="vertical-align: middle; margin-right: 10px;"
                    alt="<?= $item['name'] ?>">
                <?= $item['name'] ?>
            </td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= $item['quantity'] ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;">
                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; text-align: right;">
        <h3>Tổng cộng: <?= number_format($order['total_amount'], 0, ',', '.') ?>đ</h3>
        <a href="/whey_web/orders" style="color: #2563eb;">← Quay lại danh sách</a>
    </div>
</div>