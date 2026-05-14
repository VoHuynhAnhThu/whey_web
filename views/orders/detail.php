<div class="order-detail-container">
    <nav class="mb-4">
        <a href="/whey_web/orders" class="text-decoration-none text-muted small fw-bold">
            <i class="bi bi-arrow-left me-1"></i> QUAY LẠI DANH SÁCH ĐƠN HÀNG
        </a>
    </nav>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="order-info-card shadow-sm rounded-4 bg-white p-4 border sticky-top" style="top: 100px;">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Thông tin đơn hàng</h5>
                
                <div class="mb-3">
                    <label class="small text-muted d-block">Mã đơn hàng</label>
                    <span class="fw-bold fs-5 text-dark">#<?= substr($order['id'], 0, 8) ?></span>
                </div>

                <div class="mb-3">
                    <label class="small text-muted d-block">Thời gian đặt</label>
                    <span class="fw-medium"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                </div>

                <div class="mb-4">
                    <label class="small text-muted d-block">Trạng thái hiện tại</label>
                    <span class="badge bg-light text-success border border-success px-3 py-2 rounded-pill mt-1">
                        <i class="bi bi-info-circle me-1"></i> <?= strtoupper($order['status']) ?>
                    </span>
                </div>

                <div class="total-box p-3 rounded-3 bg-light text-center border">
                    <div class="small text-muted mb-1">Tổng tiền thanh toán</div>
                    <div class="h3 fw-800 text-success m-0"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="order-items-card shadow-sm rounded-4 bg-white overflow-hidden border">
                <div class="p-4 border-bottom bg-light">
                    <h5 class="m-0 fw-bold text-dark">Sản phẩm đã mua</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle m-0">
                        <thead>
                            <tr class="bg-white border-bottom border-light">
                                <th class="ps-4 py-3 small text-muted text-uppercase">Sản phẩm</th>
                                <th class="py-3 small text-muted text-uppercase text-center">Số lượng</th>
                                <th class="py-3 small text-muted text-uppercase text-end pe-4">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-img rounded border bg-light p-1" style="width: 50px; height: 50px;">
                                                <img src="/whey_web/<?= $item['url'] ?? 'assets/images/no-image.png' ?>" 
                                                     class="img-fluid h-100 w-100 object-fit-contain" alt="product">
                                            </div>
                                            <div class="fw-bold text-dark small" style="max-width: 250px;">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center fw-medium">x <?= $item['quantity'] ?></td>
                                    <td class="py-3 text-end pe-4 fw-bold text-dark">
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-light text-end">
                    <span class="text-muted me-2 small">Tạm tính:</span>
                    <span class="fw-bold text-dark h5 mb-0"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .object-fit-contain { object-fit: contain; }
</style>