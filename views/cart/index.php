<div class="cart-page-container">
    <div class="cart-header mb-4 pb-2 border-bottom border-3" style="border-color: var(--fit-primary) !important;">
        <h2 class="fw-800 text-dark m-0">Giỏ hàng của bạn</h2>
    </div>

    <?php if (empty($items)): ?>
        <div class="empty-cart-card text-center py-5 shadow-sm rounded-4 bg-white border">
            <div class="empty-cart-icon mb-4" style="font-size: 5rem; color: #e5e7eb;">
                <i class="bi bi-cart-x"></i>
            </div>
            <h4 class="text-dark fw-bold">Giỏ hàng đang trống</h4>
            <p class="text-muted mb-4">Có vẻ như bạn chưa chọn được sản phẩm nào ưng ý.</p>
            <a href="/whey_web/products" class="btn btn-fit-primary px-4 py-2 rounded-pill fw-bold">
                TIẾP TỤC MUA SẮM
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-items-list shadow-sm rounded-4 bg-white overflow-hidden border">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle m-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Sản phẩm</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Đơn giá</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Số lượng</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="product-img-box rounded-3 border p-1 bg-light" style="width: 70px; height: 70px;">
                                                    <img src="/whey_web/<?= $item['url'] ?? 'assets/images/no-image.png' ?>" 
                                     style="width: 60px; height: 60px; object-fit: contain;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark text-truncate" style="max-width: 200px;"><?= htmlspecialchars($item['name']) ?></div>
                                                    <form action="/whey_web/cart/remove" method="post" class="mt-1">
                                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                        <button type="submit" class="btn p-0 text-danger small bg-transparent border-0">
                                                            <i class="bi bi-trash3 me-1"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 fw-medium"><?= number_format($item['sale_price'], 0, ',', '.') ?>đ</td>
                                        <td class="py-4 text-center">
                                            <span class="badge bg-light text-dark border px-3 py-2 fs-6">x <?= $item['quantity'] ?></span>
                                        </td>
                                        <td class="py-4 text-end pe-4 fw-bold text-success">
                                            <?= number_format($item['sale_price'] * $item['quantity'], 0, ',', '.') ?>đ
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary-card shadow-sm rounded-4 bg-white p-4 border sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Tóm tắt đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 fw-bold m-0">Tổng cộng:</span>
                        <span class="h4 fw-800 text-success m-0"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    
                    <form action="/whey_web/cart/checkout" method="post">
                        <button type="submit" class="btn btn-fit-primary w-100 py-3 rounded-3 fw-bold fs-5 shadow-sm transition-all">
                            XÁC NHẬN THANH TOÁN <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                    
                    <div class="mt-4 p-3 bg-light rounded-3 small text-muted">
                        <i class="bi bi-shield-check text-success me-2"></i> 
                        Thanh toán an toàn với cam kết bảo mật từ FITWHEY.
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .btn-fit-primary { background-color: var(--fit-primary); color: white; border: none; }
    .btn-fit-primary:hover { background-color: #059669; color: white; transform: translateY(-2px); }
    .transition-all { transition: all 0.3s ease; }
    .object-fit-contain { object-fit: contain; }
</style>