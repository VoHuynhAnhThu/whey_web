<div class="container" style="padding: 20px; max-width: 1000px; margin: 0 auto;">
    <form action="/whey_web/admin/products/store" method="POST" class="card" style="padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom: 25px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">Thêm sản phẩm mới</h2>

        <!-- PHẦN 1: THÔNG TIN CƠ BẢN (Bảng Products)[cite: 1] -->
        <h3 style="color: var(--primary);">1. Thông tin cơ bản</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Danh mục:</label>
                <select name="category_id" style="width: 100%; padding: 8px; margin-top: 5px;">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Giá niêm yết (Price):</label>
                <input type="number" name="price" step="0.01" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Giá khuyến mãi (Sale Price):</label>
                <input type="number" name="sale_price" step="0.01" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Số lượng kho (Stock):</label>
                <input type="number" name="stock_quantity" value="0" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Hương vị (Flavor):</label>
                <input type="text" name="flavor" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="margin-top: 20px;">
                <label>Mô tả sản phẩm:</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
            </div>
        </div>

        <!-- PHẦN 2: THÔNG TIN DINH DƯỠNG (Bảng Product_Nutrition)[cite: 1] -->
        <h3 style="color: var(--primary);">2. Chỉ số dinh dưỡng</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 30px; background: #f9f9f9; padding: 15px; border-radius: 5px;">
            <div>
                <label>Serving Size:</label>
                <input type="number" name="serving_size" step="0.01" required style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Đơn vị (g/scoop):</label>
                <input type="text" name="serving_unit" placeholder="g" required style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Calories:</label>
                <input type="number" name="calories" step="0.1" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Protein (g):</label>
                <input type="number" name="protein" step="0.1" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Carbs (g):</label>
                <input type="number" name="carbs" step="0.1" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label>Fat (g):</label>
                <input type="number" name="fat" step="0.1" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <!-- PHẦN 3: HÌNH ẢNH (Bảng Product_Images)[cite: 1] -->
        <h3 style="color: var(--primary); margin-top: 25px;">3. Hình ảnh sản phẩm</h3>
        <div style="margin-bottom: 30px; background: #f0fdf4; padding: 15px; border-radius: 5px; border: 1px dashed var(--primary);">
            <label>Chọn ảnh từ máy tính:</label>
            <!-- Đổi type="text" thành type="file"[cite: 2] -->
            <input type="file" name="product_image" accept="image/*" required style="width: 100%; margin-top: 10px;">
        </div>

        <div style="text-align: right;">
            <a href="/whey_web/admin/products" style="margin-right: 15px; text-decoration: none; color: #666;">Hủy bỏ</a>
            <button type="submit" style="padding: 10px 30px; background: var(--primary); color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                LƯU SẢN PHẨM
            </button>
        </div>
    </form>
</div>