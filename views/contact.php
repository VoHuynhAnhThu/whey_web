<section class="contact-page py-5">
    <div class="container">
        <div class="text-center mb-5">
            <?php if (isset($success) && $success == 1): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px; background-color: #d1fae5; color: #065f46;">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Gửi thành công!</strong> Tin nhắn của bạn đã được hệ thống ghi nhận. Chúng tôi sẽ phản hồi sớm nhất nhé! Xin cảm ơn
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
            <h1 class="fw-bold" style="font-size: 32px;">LIÊN HỆ VỚI <span style="color: var(--fit-primary);">CHÚNG TÔI</span></h1>
            <div style="width: 50px; height: 4px; background: var(--fit-primary); margin: 10px auto;"></div>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-lg-5 ">
                <div class="p-4 shadow-sm h-100" style="border-radius: 20px; background: #fff; border: 1px solid #eee;">
                    <h3 class="fw-bold mb-4" style="font-size: 24px;">Thông tin liên hệ</h3>
                    
                    <div class="d-flex align-items-start mb-4">
                        <i class="bi bi-geo-alt-fill me-3" style="color: var(--fit-primary); font-size: 24px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Địa chỉ cửa hàng</h6>
                            <p class="text-muted mb-0">1000 Phạm Văn Thuận, phường Tam Hiệp, Biên Hòa, Đồng Nai</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <i class="bi bi-telephone-fill me-3" style="color: var(--fit-primary); font-size: 24px;"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Hotline</h6>
                            <p class="text-muted mb-0">0909 123 456</p>
                        </div>
                    </div>

                    <div class="mt-4 overflow-hidden" style="border-radius: 15px; height: 200px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.085520995366!2d106.84516710882163!3d10.956912389157988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174dc2736a3222f%3A0x78e10d1a4ca03625!2zMTAwMCBQaOG6oW0gVsSDbiBUaHXhuq1uLCBUYW0gSGnhu4dwLCDEkOG7k25nIE5haSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1778581634170!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Ô nhập liệu chuẩn Figma */
    .fit-input {
        background: #F3F4F6 !important;
        border: 2px solid transparent !important;
        border-radius: 15px !important;
        padding: 12px 20px;
        width: 100%;
        outline: none;
        transition: 0.3s;
    }
    .fit-input:focus {
        border-color: var(--fit-primary) !important;
        background: #fff !important;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.1);
    }
    .btn-fit-primary {
        background-color: var(--fit-primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-fit-primary:hover {
        background-color: #0d9468;
        transform: translateY(-2px);
    }
</style>