<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../../../assets/css/app.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }
        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f9fafb;
            border-radius: 8px;
        }
        .price-tag {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<main class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="margin: 0;"><?= $title ?></h2>
        
        <form action="/whey_web/products" method="GET" style="display: flex; gap: 8px; width: 100%; max-width: 350px;">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." value="<?= htmlspecialchars($keyword ?? '') ?>">
            <button type="submit">Tìm</button>
        </form>
    </div>

    <?php if (empty($products)): ?>
        <div class="card" style="text-align: center; padding: 48px;">
            <p>Không tìm thấy sản phẩm nào.</p>
        </div>
    <?php else: ?>
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
    <?php foreach ($products as $product): ?>
        <div class="card product-item" style="display: flex; flex-direction: column; height: 100%; padding: 16px;">
            <!-- Phần thông tin (Ảnh + Tên + Giá) -->
            <div style="flex-grow: 1;"> 
                <a href="/whey_web/product?slug=<?= $product['slug'] ?>" style="text-decoration: none; color: inherit;">
                    <!-- Sửa đường dẫn ảnh -->
                    <img src="/whey_web/<?= $product['url'] ?? 'assets/images/no-image.png' ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>" 
                         style="width: 100%; height: 200px; object-fit: contain; background: #f9fafb; border-radius: 8px;">
                    
                    <h3 style="font-size: 1.1rem; margin: 12px 0 8px; min-height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= $product['name'] ?>
                    </h3>
                    
                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 8px;">Vị: <?= $product['flavor'] ?></p>
                    
                    <div style="margin-bottom: 12px;">
                        <span class="price-tag" style="color: var(--primary); font-weight: 700; font-size: 1.2rem;">
                            <?= number_format($product['sale_price'], 0, ',', '.') ?>đ
                        </span>
                    </div>
                </a>
            </div>

            <!-- Nút "Thêm vào giỏ" luôn nằm sát đáy -->
            <form action="/whey_web/cart/add" method="POST" style="margin-top: auto;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" style="width: 100%; background: var(--text); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer;">
                    Thêm vào giỏ
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
    <?php endif; ?>
</main>

<footer class="container" style="margin-top: 48px; padding: 24px 0; border-top: 1px solid var(--border); text-align: center; color: #6b7280;">
    <p>&copy; 2026 Fitwhey Project</p>
</footer>

</body>
</html>