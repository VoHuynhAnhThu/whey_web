<section class="hero-wrap d-flex align-items-center justify-content-center text-center" style="
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/whey_web/assets/images/bg-hero.jpg'); 
    background-size: cover; 
    background-position: center; 
    min-height: 500px; 
    color: white; 
    border-radius: 0 0 30px 30px; 
    margin-top: -20px;">
    <div class="container">
        <h1 class="display-3 fw-800 mb-3" style="letter-spacing: -1px;">
            NÂNG TẦM <span style="color: var(--fit-primary);">VÓC DÁNG</span> CÙNG FITWHEY
        </h1>
        <p class="fs-5 mb-4 mx-auto" style="max-width: 600px; opacity: 0.9;">
            <?= htmlspecialchars($settings['site_intro'] ?? 'Chuyên cung cấp thực phẩm thể hình chất lượng cao, cam kết chính hãng 100% tại Biên Hòa.') ?>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/whey_web/products" class="btn-fit-primary text-decoration-none shadow-lg">MUA SẮM NGAY</a>
            <a href="/whey_web/contact" class="btn btn-outline-light px-4 py-2" style="border-radius: 12px; font-weight: 600;">TƯ VẤN MIỄN PHÍ</a>
        </div>
    </div>
</section>

<section class="container my-5 py-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold">DANH MỤC NỔI BẬT</h2>
        <div style="width: 60px; height: 4px; background: var(--fit-primary); margin: 15px auto;"></div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="category-card border-0 shadow-sm p-4 text-center h-100">
                <div class="icon-circle mb-3 mx-auto">
                    <img src="/whey_web/assets/images/whey-icon.png" alt="Whey" class="img-fluid" style="width: 70px;">
                </div>
                <h3 class="h4 fw-bold">Whey Protein</h3>
                <p class="text-muted small">Tăng cơ bắp nhanh chóng với các dòng Whey Isolate tinh khiết nhất.</p>
                <a href="/whey_web/products?cat=whey" class="stretched-link text-decoration-none fw-bold" style="color: var(--fit-primary);">Khám phá ngay →</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category-card border-0 shadow-sm p-4 text-center h-100">
                <div class="icon-circle mb-3 mx-auto">
                    <img src="/whey_web/assets/images/mass-icon.png" alt="Mass" class="img-fluid" style="width: 70px;">
                </div>
                <h3 class="h4 fw-bold">Sữa tăng cân (Mass)</h3>
                <p class="text-muted small">Giải pháp tăng cân, thoát gầy an toàn và hiệu quả cho người tập gym.</p>
                <a href="/whey_web/products?cat=mass" class="stretched-link text-decoration-none fw-bold" style="color: var(--fit-primary);">Khám phá ngay →</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category-card border-0 shadow-sm p-4 text-center h-100">
                <div class="icon-circle mb-3 mx-auto">
                    <img src="/whey_web/assets/images/pre-icon.png" alt="Pre" class="img-fluid" style="width: 70px;">
                </div>
                <h3 class="h4 fw-bold">Pre-Workout</h3>
                <p class="text-muted small">Bùng nổ năng lượng, tỉnh táo và bền bỉ trong từng buổi tập.</p>
                <a href="/whey_web/products?cat=pre" class="stretched-link text-decoration-none fw-bold" style="color: var(--fit-primary);">Khám phá ngay →</a>
            </div>
        </div>
    </div>
</section>

<style>
    .fw-800 { font-weight: 800; }
    .category-card {
        background: #fff;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
    }
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        background: var(--fit-bg-light);
    }
    .icon-circle {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>