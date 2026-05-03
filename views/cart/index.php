<div style="padding-top: 20px;">
    <h1 style="color: var(--text);">Giỏ hàng của bạn</h1> <!-- Sử dụng màu từ app.css -->

    <!-- Kiểm tra đúng biến $items đã truyền từ Controller -->
    <?php if (empty($items)): ?>
        <div class="card" style="text-align: center; padding: 60px;"> <!-- Class card từ app.css -->
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="/whey_web/products" style="color: var(--primary);">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <div class="card">
                <table style="width: 100%;">
                    <?php foreach ($items as $item): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px 0; display: flex; align-items: center; gap: 12px;">
                                <img src="/whey_web/<?= $item['url'] ?? 'assets/images/no-image.png' ?>" 
                                     style="width: 60px; height: 60px; object-fit: contain;">
                                <div>
                                    <div style="font-weight: 600;"><?= htmlspecialchars($item['name']) ?></div>
                                </div>
                            </td>
                            <td><?= number_format($item['sale_price'], 0, ',', '.') ?>đ</td>
                            <td>x <?= $item['quantity'] ?></td>
                            <td style="text-align: right; font-weight: bold; color: var(--primary);">
                                <?= number_format($item['sale_price'] * $item['quantity'], 0, ',', '.') ?>đ
                            </td>
                            <td>
                                <form action="/whey_web/cart/remove" method="post">
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            
            <div class="card">
                <h3>Tổng cộng: <span style="color: var(--primary);"><?= number_format($total, 0, ',', '.') ?>đ</span></h3>
                <form action="/whey_web/cart/checkout" method="post">
                    <button type="submit" style="width: 100%; padding: 12px; background: var(--primary); color: white; border-radius: 8px;">
                        XÁC NHẬN THANH TOÁN
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>