<style>
    .dashboard-widget {
        display: block;
        text-decoration: none !important;
        color: white !important;
        border-radius: 15px;
        padding: 40px 30px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .dashboard-widget:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
    }
    .widget-icon { font-size: 2rem; margin-right: 15px; opacity: 0.8; }
    .widget-text { font-size: 1.5rem; font-weight: 700; letter-spacing: 1px; }
    
    .bg-lien-he { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-cai-dat { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
    .bg-about { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .bg-faq { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6">
            <a href="/whey_web/admin/contacts" class="dashboard-widget bg-lien-he">
                <div class="d-flex align-items-center justify-content-between">
                    <div><i class="ti-email widget-icon"></i><span class="widget-text">LIÊN HỆ MỚI</span></div>
                    <i class="ti-arrow-right"></i>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="/whey_web/admin/settings" class="dashboard-widget bg-cai-dat">
                <div class="d-flex align-items-center justify-content-between">
                    <div><i class="ti-settings widget-icon"></i><span class="widget-text">CÀI ĐẶT HỆ THỐNG</span></div>
                    <i class="ti-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="text-center my-5">
        <h3 class="fw-bold">
            Chào Mừng Admin 
            <span style="color: #10B981;">
                <?= htmlspecialchars($admin['full_name'] ?? 'Hệ Thống') ?>!
            </span>
        </h3>
        <p class="text-muted">Hệ thống đã sẵn sàng. Bạn đang quản lý với email: <b><?= htmlspecialchars($admin['email'] ?? '') ?></b></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10 mb-3">
            <a href="/whey_web/admin/settings/about" class="dashboard-widget bg-about py-3">
                <div class="d-flex align-items-center">
                    <i class="ti-layout widget-icon fs-4"></i>
                    <span class="fw-bold">Chỉnh sửa trang Giới thiệu</span>
                </div>
            </a>
        </div>
        <div class="col-md-10">
            <a href="/whey_web/admin/faqs" class="dashboard-widget bg-faq py-3">
                <div class="d-flex align-items-center">
                    <i class="ti-help-alt widget-icon fs-4"></i>
                    <span class="fw-bold">Quản lý câu hỏi (FAQ)</span>
                </div>
            </a>
        </div>
    </div>
</div>