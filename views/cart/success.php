<div style="padding: 60px 0; text-align: center;">
    <div class="card" style="max-width: 600px; margin: 0 auto; padding: 40px;">
        <div style="width: 80px; height: 80px; background: #ecfdf5; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px;">
            ✓
        </div>
        
        <h1 style="color: var(--text); margin-bottom: 16px;">Đặt hàng thành công!</h1>
        <p style="color: #6b7280; font-size: 1.1rem; line-height: 1.6; margin-bottom: 32px;">
            Cảm ơn bạn đã tin tưởng Fitwhey. <br>
            Mã đơn hàng của bạn là: <strong>#FW<?= time() ?></strong>. <br>
            Chúng tôi sẽ liên hệ với bạn để xác nhận trong thời gian sớm nhất.
        </p>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="/whey_web/products" style="text-decoration: none; background: var(--primary); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600;">
                Tiếp tục mua sắm
            </a>
            <a href="/whey_web/" style="text-decoration: none; background: var(--text); color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600;">
                Về trang chủ
            </a>
        </div>
    </div>
</div>