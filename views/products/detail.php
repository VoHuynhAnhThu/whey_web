<div style="padding-top: 20px;">
    <!-- Nút quay lại danh sách -->
    <a href="/whey_web/products" style="text-decoration: none; color: var(--text); display: inline-flex; align-items: center; margin-bottom: 20px; font-weight: 600;">
        <span style="margin-right: 8px;">&larr;</span> Quay lại danh sách
    </a>

    <div class="card" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
        <!-- Bên trái: Hình ảnh sản phẩm -->
        <div style="background: #f9fafb; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: center; aspect-ratio: 1/1;">
            <img src="<?= $product['url'] ?? '/whey_web/assets/images/no-image.png' ?>" 
                 alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" 
                 style="max-width: 100%; max-height: 400px; object-fit: contain;">
        </div>

        <!-- Bên phải: Thông tin chi tiết -->
        <div style="display: flex; flex-direction: column;">
            <h1 style="margin: 0 0 12px 0; font-size: 2rem; color: var(--text);"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h1>
            
            <p style="color: #6b7280; font-size: 1.1rem; margin-bottom: 20px;">
                Hương vị: <strong style="color: var(--text);"><?= htmlspecialchars($product['flavor'] ?? 'Đang cập nhật', ENT_QUOTES, 'UTF-8') ?></strong>
            </p>

            <div style="margin-bottom: 24px; display: flex; align-items: baseline; gap: 15px;">
                <span style="font-size: 2.2rem; font-weight: 700; color: var(--primary);">
                    <?= number_format($product['sale_price'], 0, ',', '.') ?>đ
                </span>
                <?php if ($product['price'] > $product['sale_price']): ?>
                    <span style="text-decoration: line-through; color: #9ca3af; font-size: 1.2rem;">
                        <?= number_format($product['price'], 0, ',', '.') ?>đ
                    </span>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 30px; line-height: 1.6; color: #4b5563;">
                <h3 style="color: var(--text); margin-bottom: 8px;">Mô tả sản phẩm</h3>
                <p><?= nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả cho sản phẩm này.', ENT_QUOTES, 'UTF-8')) ?></p>
            </div>

            <!-- Form thêm vào giỏ hàng -->
            <form action="/whey_web/cart/add" method="post" style="margin-top: auto;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 15px;">
                    <div>
                        <label for="quantity" style="display: block; margin-bottom: 5px; font-size: 0.85rem;">Số lượng</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" style="text-align: center;">
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button type="submit" style="width: 100%; height: 46px; font-size: 1.1rem;">
                            THÊM VÀO GIỎ HÀNG
                        </button>
                    </div>
                </div>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #6b7280;">
                    Còn lại: <?= $product['stock_quantity'] ?> sản phẩm trong kho
                </p>
            </form>
        </div>
    </div>
</div>