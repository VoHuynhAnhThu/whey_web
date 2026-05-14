<div class="product-page-container">
    <div class="product-header">
        <h1><?= htmlspecialchars($title) ?></h1>
        <p class="text-muted">Khám phá các sản phẩm thực phẩm bổ sung cao cấp tại FITWHEY.</p>
    </div>

    <div class="product-search">
        <form method="GET" action="/whey_web/products">
            <div class="search-form-group">
                <input type="text" name="search" placeholder="Bạn đang tìm sản phẩm gì?..."
                    value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES, 'UTF-8') ?>" class="form-control">
                <button type="submit" class="btn btn-fit-primary">Tìm kiếm</button>
            </div>
        </form>
    </div>

    <?php if (count($products) > 0): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="card-badges">
                        <?php if ($product['sale_price'] < $product['price']): ?>
                            <span class="badge badge-sale">SALE</span>
                        <?php endif; ?>
                        
                        <?php 
                            $createdDate = strtotime($product['created_at'] ?? 'now');
                            if ((time() - $createdDate) / (60 * 60 * 24) < 7): ?>
                                <span class="badge badge-new">NEW</span>
                        <?php endif; ?>
                    </div>

                    <div class="card-image">
                        <a href="/whey_web/products/detail?slug=<?= htmlspecialchars($product['slug'], ENT_QUOTES, 'UTF-8') ?>">
                            <img src="/whey_web/<?= $product['url'] ?? 'assets/images/no-image.png' ?>" 
                            alt="<?= htmlspecialchars($product['name']) ?>" 
                            style="width: 100%; height: 200px; object-fit: contain; background: #f9fafb; border-radius: 8px;">
                        </a>
                    </div>

                    <div class="card-content">
                        <span class="category-label"><?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?></span>
                        <h3 class="card-title">
                            <a href="/whey_web/products/detail?slug=<?= htmlspecialchars($product['slug'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>

                        <div class="price-box">
                            <span class="current-price"><?= number_format($product['sale_price'], 0, ',', '.') ?>đ</span>
                            <?php if ($product['price'] > $product['sale_price']): ?>
                                <span class="old-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <form action="/whey_web/cart/add" method="POST" class="w-100">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">
                                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-light text-center py-5">
            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
            Không tìm thấy sản phẩm nào phù hợp.
        </div>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
        <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>&search=<?= urlencode($keyword) ?>" 
                style="padding: 10px 18px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; color: #333;">&laquo; Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($keyword) ?>" 
                style="padding: 10px 18px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; 
                        <?= $i === $currentPage ? 'background: #10B981; color: white; border-color: #10B981;' : 'color: #333;' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>&search=<?= urlencode($keyword) ?>" 
                style="padding: 10px 18px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; color: #333;">Sau &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .product-page-container { padding: 20px 0; }
    .product-header { margin-bottom: 30px; border-bottom: 3px solid var(--fit-primary); padding-bottom: 15px; }
    .product-header h1 { font-weight: 800; color: var(--fit-dark); margin: 0; }
    
    .product-search { background: #f9f9f9; padding: 20px; border-radius: 12px; margin-bottom: 40px; }
    .search-form-group { display: flex; gap: 10px; }
    
    .product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
    
    .product-card { 
        background: #fff; border-radius: 10px; overflow: hidden; position: relative;
        transition: transform 0.3s, box-shadow 0.3s; box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        display: flex; flex-direction: column; height: 100%;
    }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
    
    .card-badges { position: absolute; top: 12px; right: 12px; z-index: 5; display: flex; flex-direction: column; gap: 5px; }
    .badge { padding: 5px 10px; font-weight: 700; font-size: 0.7rem; border-radius: 4px; }
    .badge-sale { background: #EF4444; color: #fff; }
    .badge-new { background: var(--fit-primary); color: #fff; }
    
    .card-image { height: 240px; background: #fdfdfd; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .card-image img { max-width: 85%; transition: 0.5s; }
    .product-card:hover .card-image img { transform: scale(1.1); }
    
    .card-content { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; }
    .category-label { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 1px; }
    .card-title { font-size: 1rem; margin: 8px 0; line-height: 1.4; height: 2.8em; overflow: hidden; }
    .card-title a { color: var(--fit-dark); text-decoration: none; }
    
    .price-box { margin-bottom: 15px; }
    .current-price { color: var(--fit-primary); font-weight: 800; font-size: 1.2rem; }
    .old-price { text-decoration: line-through; color: #bbb; font-size: 0.9rem; margin-left: 8px; }
    
    .btn-add-cart { 
        width: 100%; background: var(--fit-dark); color: #fff; border: none; padding: 10px;
        border-radius: 6px; font-weight: 600; transition: 0.3s;
    }
    .btn-add-cart:hover { background: var(--fit-primary); }

    @media (max-width: 1100px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .product-grid { grid-template-columns: 1fr; } }
</style>