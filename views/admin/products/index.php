<div class="admin-container" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Quản lý sản phẩm</h2>
        <a href="/whey_web/admin/products/create" class="btn-primary" style="padding: 10px 20px; background: var(--primary); color: white; border-radius: 5px; text-decoration: none;">+ Thêm sản phẩm</a>
    </div>

    <!-- Thanh tìm kiếm[cite: 1] -->
    <div class="card" style="margin-bottom: 20px; padding: 15px;">
        <form action="/whey_web/admin/products" method="get" style="display: flex; gap: 10px;">
            <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Tìm tên sản phẩm hoặc mã..." style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <button type="submit" style="padding: 8px 20px; cursor: pointer;">Tìm kiếm</button>
        </form>
    </div>

    <!-- Bảng danh sách[cite: 1] -->
    <div class="card">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f4f4f4; text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px;">Sản phẩm</th>
                    <th style="padding: 12px;">Danh mục</th>
                    <th style="padding: 12px;">Giá (Sale)</th>
                    <th style="padding: 12px;">Kho</th>
                    <th style="padding: 12px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">
                        <strong><?= htmlspecialchars($product['name']) ?></strong>
                    </td>
                    <td style="padding: 12px;"><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></td>
                    <td style="padding: 12px;">
                        <?= number_format($product['price'], 0, ',', '.') ?>đ 
                        <br><small style="color: red;"><?= number_format($product['sale_price'], 0, ',', '.') ?>đ</small>
                    </td>
                    <td style="padding: 12px;"><?= $product['stock_quantity'] ?></td>
                    <td style="padding: 12px;">
                        <a href="/whey_web/admin/products/edit?id=<?= $product['id'] ?>" class="btn-edit">Sửa</a>
                        <form action="/whey_web/admin/products/delete" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <button type="submit" class="btn-delete" style="color: red; border: none; background: none; cursor: pointer;">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

        <!-- PHẦN PHÂN TRANG -->
    <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center; gap: 5px;">
    
        <!-- Nút Quay lại -->
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #333;">&laquo; Trước</a>
        <?php endif; ?>

        <!-- Hiển thị các số trang -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" 
            style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; 
                    <?= $i === $currentPage ? 'background: var(--primary); color: white;' : 'color: #333;' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Nút Tiếp theo -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #333;">Sau &raquo;</a>
        <?php endif; ?>

    </div>
</div>