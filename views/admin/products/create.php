<div class="card mt-4 mb-4">
    <div class="card-body">
        <h4 class="header-title mb-4 border-bottom pb-2">Thêm sản phẩm mới</h4>
        
        <form action="/whey_web/admin/products/store" method="POST" enctype="multipart/form-data">
            
            <h5 class="text-primary mb-3"><i class="ti-info-alt me-1"></i> 1. Thông tin cơ bản</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Tên sản phẩm:</label>
                    <input type="text" name="name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Danh mục:</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Giá niêm yết (Price):</label>
                    <input type="number" name="price" step="0.01" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Giá khuyến mãi (Sale Price):</label>
                    <input type="number" name="sale_price" step="0.01" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Số lượng kho (Stock):</label>
                    <input type="number" name="stock_quantity" value="0" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Hương vị (Flavor):</label>
                    <input type="text" name="flavor" class="form-control form-control-sm">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold small text-secondary">Mô tả sản phẩm:</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>
            </div>

            <h5 class="text-primary mb-3"><i class="ti-heart-broken me-1"></i> 2. Chỉ số dinh dưỡng</h5>
            <div class="row g-3 p-3 bg-light rounded mb-4">
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Serving Size:</label>
                    <input type="number" name="serving_size" step="0.01" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Đơn vị (g/scoop):</label>
                    <input type="text" name="serving_unit" placeholder="g" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Calories:</label>
                    <input type="number" name="calories" step="0.1" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Protein (g):</label>
                    <input type="number" name="protein" step="0.1" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Carbs (g):</label>
                    <input type="number" name="carbs" step="0.1" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Fat (g):</label>
                    <input type="number" name="fat" step="0.1" class="form-control form-control-sm">
                </div>
            </div>

            <h5 class="text-primary mb-3"><i class="ti-image me-1"></i> 3. Hình ảnh sản phẩm</h5>
            <div class="p-3 border rounded border-dashed bg-light mb-4" style="border-style: dashed !important;">
                <label class="form-label small text-muted">Chọn ảnh từ máy tính:</label>
                <input type="file" name="product_image" class="form-control" accept="image/*" required>
            </div>

            <div class="text-end">
                <a href="/whey_web/admin/products" class="btn btn-light btn-sm px-4 me-2 border">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">LƯU SẢN PHẨM</button>
            </div>
        </form>
    </div>
</div>