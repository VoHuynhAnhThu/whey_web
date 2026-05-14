<div class="product-detail-container mt-2">
    <nav aria-label="breadcrumb" class="mb-4">
        <a href="/whey_web/products" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh mục sản phẩm
        </a>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="product-gallery p-5 rounded-4 bg-light text-center">
                <img src="/whey_web/<?= $product['url'] ?? '/whey_web/assets/images/no-image.png' ?>" 
                    alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" 
                    style="max-width: 100%; max-height: 400px; object-fit: contain;">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="product-info-header">
                <span class="badge bg-success mb-2"><?= htmlspecialchars($product['category_name'] ?? 'Whey Protein') ?></span>
                <h1 class="display-6 fw-bold mb-3"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="fs-2 fw-800 text-success">
                        <?= number_format($product['sale_price'], 0, ',', '.') ?>đ
                    </span>
                    <?php if ($product['price'] > $product['sale_price']): ?>
                        <span class="text-decoration-line-through text-muted fs-5">
                            <?= number_format($product['price'], 0, ',', '.') ?>đ
                        </span>
                    <?php endif; ?>
                </div>

                <div class="product-meta mb-4 p-3 bg-light rounded-3">
                    <p class="mb-1 small"><strong>Hương vị:</strong> <?= htmlspecialchars($product['flavor'] ?? 'Tự nhiên') ?></p>
                    <p class="mb-0 small"><strong>Trình trạng:</strong> 
                        <span class="<?= $product['stock_quantity'] > 0 ? 'text-success' : 'text-danger' ?>">
                            <?= $product['stock_quantity'] > 0 ? 'Còn hàng (' . $product['stock_quantity'] . ')' : 'Hết hàng' ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="product-description mb-5">
                <h6 class="fw-bold border-bottom pb-2 mb-3">Mô tả sản phẩm</h6>
                <div class="text-muted" style="line-height: 1.7;">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả cho sản phẩm này.')) ?>
                </div>
            </div>

            <form action="/whey_web/cart/add" method="POST" class="add-to-cart-form shadow-sm p-4 rounded-4 border">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="row g-3">
                    <div class="col-4">
                        <label class="form-label small fw-bold">Số lượng</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $product['stock_quantity'] ?>">
                    </div>
                    <div class="col-8 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold" <?= $product['stock_quantity'] <= 0 ? 'disabled' : '' ?>>
                            <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .product-gallery { border: 1px solid #eee; position: sticky; top: 100px; }
    .main-img { max-height: 450px; object-fit: contain; }
    .add-to-cart-form { background: #fff; }
</style>