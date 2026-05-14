<div class="card mt-4">
    <div class="card-body">
        <h3 class="header-title mb-4">Chi tiết sản phẩm trong đơn hàng</h3>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 100px;">Hình ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá mua</th>
                        <th scope="col" style="width: 100px; text-align: center;">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="/whey_web/<?= htmlspecialchars($item['image_url'] ?? '') ?>" 
                                 width="60" class="img-thumbnail" alt="Product image">
                        </td>
                        <td class="fw-bold text-secondary"><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                        <td style="text-align: center;">
                            <span class="badge bg-secondary px-3 py-2 fs-6"><?= $item['quantity'] ?></span>
                        </td>
                        <td class="fw-bold text-primary">
                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="/whey_web/admin/orders" class="btn btn-secondary btn-sm px-3">
                <i class="ti-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</div>