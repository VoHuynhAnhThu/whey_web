<div class="card mt-4 mb-4">
    <div class="card-body">
        <h4 class="header-title mb-4 border-bottom pb-2">
            Chỉnh sửa: <?= htmlspecialchars($product['name']) ?>
        </h4>
        
        <form action="/whey_web/admin/products/update" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <input type="hidden" name="old_image_url" value="<?= $product['image_url'] ?>">

            <h5 class="text-primary mb-3"><i class="ti-info-alt me-1"></i> 1. Thông tin cơ bản</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Tên sản phẩm:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Danh mục:</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Giá niêm yết (Price):</label>
                    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Giá khuyến mãi (Sale Price):</label>
                    <input type="number" name="sale_price" step="0.01" value="<?= $product['sale_price'] ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-secondary">Số lượng tồn kho:</label>
                    <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Hương vị (Flavor):</label>
                    <input type="text" name="flavor" value="<?= htmlspecialchars($product['flavor']) ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">Khối lượng (Weight):</label>
                    <input type="text" name="weight" value="<?= htmlspecialchars($product['weight'] ?? '') ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold small text-secondary">Mô tả sản phẩm:</label>
                    <textarea name="description" rows="4" class="form-control"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>
            </div>

            <h5 class="text-primary mb-3"><i class="ti-heart-broken me-1"></i> 2. Chỉ số dinh dưỡng</h5>
            <div class="row g-3 p-3 bg-light rounded mb-4">
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Serving Size:</label>
                    <input type="number" name="serving_size" step="0.01" value="<?= $product['serving_size'] ?>" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Đơn vị (g/scoop):</label>
                    <input type="text" name="serving_unit" value="<?= htmlspecialchars($product['serving_unit']) ?>" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Calories:</label>
                    <input type="number" name="calories" step="0.1" value="<?= $product['calories'] ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Protein (g):</label>
                    <input type="number" name="protein" step="0.1" value="<?= $product['protein'] ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Carbs (g):</label>
                    <input type="number" name="carbs" step="0.1" value="<?= $product['carbs'] ?>" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Fat (g):</label>
                    <input type="number" name="fat" step="0.1" value="<?= $product['fat'] ?>" class="form-control form-control-sm">
                </div>
            </div>

            <h5 class="text-primary mb-3"><i class="ti-image me-1"></i> 3. Hình ảnh sản phẩm</h5>
            <div class="p-3 border rounded bg-light mb-4" style="border-style: dashed !important;">
                <div class="row align-items-center g-3">
                    <div class="col-sm-2 text-center border-end">
                        <span class="d-block small text-muted mb-1">Ảnh hiện tại:</span>
                        <img src="/whey_web/<?= $product['image_url'] ?>" alt="Product image" class="img-thumbnail" style="max-width: 100px;">
                    </div>
                    <div class="col-sm-10">
                        <label class="form-label small text-muted">Thay đổi ảnh mới (để trống nếu giữ nguyên):</label>
                        <input type="file" name="product_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="/whey_web/admin/products" class="btn btn-light btn-sm px-4 me-2 border">Hủy bỏ</a>
                <button type="submit" class="btn btn-success btn-sm px-4 fw-bold">CẬP NHẬT THAY ĐỔI</button>
            </div>
        </form>
    </div>
</div>