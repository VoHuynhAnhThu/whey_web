<div class="order-history-container">
    <div class="order-header mb-4 pb-2 border-bottom border-3" style="border-color: var(--fit-primary) !important;">
        <h2 class="fw-800 text-dark m-0">Lịch sử đơn hàng</h2>
        <p class="text-muted mt-1 small">Theo dõi và quản lý các đơn hàng bạn đã đặt tại FITWHEY.</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-orders-card text-center py-5 shadow-sm rounded-4 bg-white border">
            <div class="empty-icon mb-4" style="font-size: 5rem; color: #e5e7eb;">
                <i class="bi bi-receipt"></i>
            </div>
            <h4 class="text-dark fw-bold">Bạn chưa có đơn hàng nào</h4>
            <p class="text-muted mb-4">Hãy khám phá các sản phẩm chất lượng của chúng tôi ngay.</p>
            <a href="/whey_web/products" class="btn btn-fit-primary px-4 py-2 rounded-pill fw-bold">
                MUA SẮM NGAY
            </a>
        </div>
    <?php else: ?>
        <div class="orders-list d-grid gap-3">
            <?php foreach ($orders as $order): ?>
                <div class="order-card shadow-sm rounded-4 bg-white p-4 border transition-hover">
                    <div class="row align-items-center g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="order-icon-box bg-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Mã đơn: #<?= substr($order['id'], 0, 8) ?></div>
                                    <div class="small text-muted">Ngày đặt: <?= date('d/m/Y', strtotime($order['created_at'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 text-md-center">
                            <?php 
                                $statusClass = 'bg-warning text-dark'; // Mặc định Pending
                                if ($order['status'] === 'Completed') $statusClass = 'bg-success text-white';
                                if ($order['status'] === 'Cancelled') $statusClass = 'bg-danger text-white';
                                if ($order['status'] === 'Processing') $statusClass = 'bg-info text-dark';
                            ?>
                            <span class="badge <?= $statusClass ?> px-3 py-2 rounded-pill fw-bold small">
                                <?= strtoupper($order['status']) ?>
                            </span>
                        </div>

                        <div class="col-md-3 text-md-end">
                            <div class="small text-muted mb-1">Tổng cộng</div>
                            <div class="h5 fw-800 text-success m-0"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</div>
                        </div>

                        <div class="col-md-2 text-end">
                            <a href="/whey_web/orders/detail?id=<?= $order['id'] ?>" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-3 fw-bold">
                                CHI TIẾT <i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center gap-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link rounded-3 border fw-bold <?= $i == $currentPage ? 'bg-success text-white border-success' : 'text-dark bg-white' ?>" href="?page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .btn-fit-primary { background-color: var(--fit-primary); color: white; border: none; }
    .btn-fit-primary:hover { background-color: #059669; color: white; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important; }
    .page-link:hover { background-color: #f8f9fa; }
</style>