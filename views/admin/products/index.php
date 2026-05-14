<div class="card mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Quản lý sản phẩm</h2>
            <a href="/whey_web/admin/products/create" class="btn btn-primary btn-sm px-3">
                <i class="fa fa-plus me-1"></i> Thêm sản phẩm
            </a>
        </div>

        <div class="bg-light p-3 rounded mb-4">
            <form action="/whey_web/admin/products" method="get" class="row g-2 align-items-center">
                <div class="col-sm-10">
                    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
                           class="form-control form-control-sm" placeholder="Tìm tên sản phẩm hoặc mã...">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-secondary btn-sm w-100">
                        <i class="ti-search me-1"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col" style="width: 180px;">Danh mục</th>
                        <th scope="col" style="width: 150px;">Giá (Sale)</th>
                        <th scope="col" style="width: 100px; text-align: center;">Kho</th>
                        <th scope="col" style="width: 150px; text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="fw-bold text-secondary"><?= htmlspecialchars($product['name']) ?></td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1">
                                <?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-dark fw-bold"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                            <?php if (!empty($product['sale_price'])): ?>
                                <br><small class="text-danger fw-bold">📉 <?= number_format($product['sale_price'], 0, ',', '.') ?>đ</small>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge <?= $product['stock_quantity'] > 0 ? 'bg-success' : 'bg-danger' ?> px-2 py-1">
                                <?= $product['stock_quantity'] ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/whey_web/admin/products/edit?id=<?= $product['id'] ?>" class="btn btn-info btn-xs text-white">
                                    <i class="fa fa-edit"></i> Sửa
                                </a>
                                <form action="/whey_web/admin/products/delete" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">&laquo;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" 
                style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; 
                        <?= $i === $currentPage ? 'background: #2563eb; color: white; border-color: #2563eb;' : 'color: #333;' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333;">&raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>