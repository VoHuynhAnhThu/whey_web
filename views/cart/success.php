<div class="success-page-container py-5">
    <div class="card shadow-sm border-0 rounded-4 max-w-600 mx-auto overflow-hidden">
        <div class="success-banner py-5 text-center" style="background-color: #ecfdf5;">
            <div class="success-icon-circle mx-auto d-flex align-items-center justify-content-center mb-3 shadow-sm" 
                 style="width: 100px; height: 100px; background: white; color: var(--fit-primary); border-radius: 50%; font-size: 50px;">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2 class="fw-800 text-dark mb-1">ĐẶT HÀNG THÀNH CÔNG!</h2>
            <div class="badge bg-success px-3 py-2 rounded-pill">Mã đơn: #FW<?= time() ?></div>
        </div>
        
        <div class="card-body p-5 text-center">
            <p class="text-muted fs-5 mb-4" style="line-height: 1.6;">
                Cảm ơn bạn đã tin tưởng <strong>FITWHEY</strong>. <br>
                Đơn hàng của bạn đã được hệ thống ghi nhận và đang trong quá trình chuẩn bị. Chúng tôi sẽ sớm liên hệ để xác nhận thông tin giao hàng.
            </p>

            <div class="row g-3">
                <div class="col-sm-6">
                    <a href="/whey_web/products" class="btn btn-outline-success w-100 py-3 rounded-3 fw-bold">
                        <i class="bi bi-bag me-2"></i> TIẾP TỤC MUA SẮM
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="/whey_web/" class="btn btn-fit-primary w-100 py-3 rounded-3 fw-bold">
                        <i class="bi bi-house me-2"></i> VỀ TRANG CHỦ
                    </a>
                </div>
            </div>
            
            <div class="mt-5 pt-4 border-top">
                <p class="small text-muted m-0">
                    Bạn có thắc mắc? Liên hệ hỗ trợ ngay: <strong>0123 456 789</strong>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .max-w-600 { max-width: 650px; }
    .fw-800 { font-weight: 800; }
    .btn-fit-primary { background-color: var(--fit-primary); color: white; border: none; }
    .btn-fit-primary:hover { background-color: #059669; color: white; }
</style>