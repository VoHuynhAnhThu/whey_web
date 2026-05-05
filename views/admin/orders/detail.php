<div class="card" style="margin: 20px; padding: 20px;">
    <h3>Chi tiết sản phẩm trong đơn hàng</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th style="padding: 10px;">Hình ảnh</th>
                <th style="padding: 10px;">Tên sản phẩm</th>
                <th style="padding: 10px;">Giá mua</th>
                <th style="padding: 10px;">Số lượng</th>
                <th style="padding: 10px;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td style="padding: 10px;"><img src="<?= $item['image_url'] ?>" width="50"></td>
                <td style="padding: 10px;"><?= htmlspecialchars($item['name']) ?></td>
                <td style="padding: 10px;"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                <td style="padding: 10px;"><?= $item['quantity'] ?></td>
                <td style="padding: 10px; font-weight: bold;">
                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        <a href="/whey_web/admin/orders"> Quay lại danh sách</a>
    </div>
</div>