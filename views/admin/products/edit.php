<div class="container" style="padding: 20px; max-width: 1000px; margin: 0 auto;">
    <!-- THAY ĐỔI 1: Thêm enctype và kiểm tra chính xác action để tránh lỗi 404[cite: 2] -->
    <form action="/whey_web/admin/products/update" method="POST" enctype="multipart/form-data" class="card" style="padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <!-- THAY ĐỔI 2: Các trường ẩn bắt buộc để Controller không báo lỗi "Undefined key" -->
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="hidden" name="old_image_url" value="<?= $product['image_url'] ?>">

        <h2 style="margin-bottom: 25px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
            Chỉnh sửa: <?= htmlspecialchars($product['name']) ?>
        </h2>

        <!-- PHẦN 1: THÔNG TIN CƠ BẢN -->
        <h3 style="color: var(--primary);">1. Thông tin cơ bản</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Danh mục:</label>
                <select name="category_id" style="width: 100%; padding: 8px; margin-top: 5px;">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Giá niêm yết (Price):</label>
                <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Giá khuyến mãi (Sale Price):</label>
                <input type="number" name="sale_price" step="0.01" value="<?= $product['sale_price'] ?>" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Số lượng tồn kho:</label>
                <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Hương vị (Flavor):</label>
                <input type="text" name="flavor" value="<?= htmlspecialchars($product['flavor']) ?>" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <!-- Bổ sung Weight để khớp với Database và Controller[cite: 1] -->
            <div>
                <label>Khối lượng (Weight):</label>
                <input type="text" name="weight" value="<?= htmlspecialchars($product['weight'] ?? '') ?>" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="grid-column: span 2; margin-top: 10px;">
                <label>Mô tả sản phẩm:</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- PHẦN 2: CHỈ SỐ DINH DƯỠNG -->
        <h3 style="color: var(--primary);">2. Chỉ số dinh dưỡng</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 30px; background: #f9f9f9; padding: 15px; border-radius: 5px;">
            <div>
                <label>Serving Size:</label>
                <input type="number" name="serving_size" step="0.01" value="<?= $product['serving_size'] ?>" required style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Đơn vị (g/scoop):</label>
                <input type="text" name="serving_unit" value="<?= htmlspecialchars($product['serving_unit']) ?>" required style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Calories:</label>
                <input type="number" name="calories" step="0.1" value="<?= $product['calories'] ?>" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Protein (g):</label>
                <input type="number" name="protein" step="0.1" value="<?= $product['protein'] ?>" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Carbs (g):</label>
                <input type="number" name="carbs" step="0.1" value="<?= $product['carbs'] ?>" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Fat (g):</label>
                <input type="number" name="fat" step="0.1" value="<?= $product['fat'] ?>" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <!-- PHẦN 3: HÌNH ẢNH -->
        <h3 style="color: var(--primary); margin-top: 25px;">3. Hình ảnh sản phẩm</h3>
        <div style="margin-bottom: 30px; background: #f0fdf4; padding: 15px; border-radius: 5px; border: 1px dashed var(--primary);">
            <div style="display: flex; align-items: start; gap: 20px;">
                <div style="text-align: center;">
                    <p style="font-size: 0.8rem; color: #666; margin-bottom: 5px;">Ảnh hiện tại:</p>
                    <img src="/whey_web/<?= $product['image_url'] ?>" alt="Ảnh hiện tại" style="max-width: 120px; border: 1px solid #ddd; background: white;">
                </div>
                <div style="flex-grow: 1;">
                    <label>Thay đổi ảnh mới (để trống nếu giữ nguyên):</label>
                    <input type="file" name="product_image" accept="image/*" style="width: 100%; margin-top: 10px;">
                    <p style="font-size: 0.85rem; color: #666; margin-top: 5px;">Hệ thống sẽ giữ lại ảnh cũ nếu bạn không chọn tệp mới.</p>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <a href="/whey_web/admin/products" style="margin-right: 15px; text-decoration: none; color: #666;">Hủy bỏ</a>
            <button type="submit" style="padding: 10px 30px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                CẬP NHẬT THAY ĐỔI
            </button>
        </div>
    </form>
</div>