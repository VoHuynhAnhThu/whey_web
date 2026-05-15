<style>
    .admin-card {
        border-radius: 20px;
        background: #fff;
        border: 1px solid #eee;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .fit-input {
        background: #F3F4F6 !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
        padding: 12px 20px;
        width: 100%;
        outline: none;
        transition: 0.3s;
        margin-top: 8px;
    }

    .fit-input:focus {
        border-color: #10B981 !important;
        background: #fff !important;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.1);
    }

    .btn-fit-primary {
        background-color: #10B981;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
        cursor: pointer;
        padding: 15px 40px;
    }

    .btn-fit-primary:hover {
        background-color: #0d9468;
        transform: translateY(-2px);
    }

    .form-label {
        font-weight: 700;
        color: #374151;
        margin-bottom: 0;
        display: block;
    }
</style>

<div class="container-fluid py-4">
    <div class="mb-4 d-flex align-items-center">
        <h2 class="fw-bold m-0">CÀI ĐẶT <span style="color: #10B981;">HỆ THỐNG</span></h2>
    </div>

    <div class="admin-card">
        <form action="/whey_web/admin/update-settings" method="POST" enctype="multipart/form-data">
            <h5 class="fw-bold mb-4" style="border-left: 5px solid #10B981; padding-left: 15px;">Cấu Hình Thông Tin
                Website</h5>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Số điện thoại công ty</label>
                    <input type="text" name="site_hotline" class="fit-input"
                        value="<?= htmlspecialchars($settings['site_hotline'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Địa chỉ công ty</label>
                    <input type="text" name="site_address" class="fit-input"
                        value="<?= htmlspecialchars($settings['site_address'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Đoạn giới thiệu ngắn</label>
                <textarea name="site_description" class="fit-input"
                    rows="4"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>
            <div class="row align-items-center mb-5 mt-4">
                <div class="col-md-4 text-center">
                    <label class="form-label d-block mb-2">Logo website hiện tại</label>
                    <div
                        style="background: #f8f9fa; padding: 15px; border-radius: 15px; border: 2px dashed #ddd; display: inline-block;">
                        <?php if (!empty($settings['site_logo'])): ?>
                            <img src="<?= asset('uploads/' . $settings['site_logo']) ?>" alt="Logo"
                                style="max-height: 60px;">
                        <?php else: ?>
                            <span class="text-danger small fw-bold">Chưa có logo</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Tải lên Logo mới (Dạng ngang sẽ đẹp hơn)</label>
                    <input type="file" name="site_logo" class="form-control mt-2"
                        style="border-radius: 12px; padding: 10px;">
                    <small class="text-muted">Định dạng: .png, .jpg, .webp. Dung lượng < 2MB</small>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-fit-primary shadow">LƯU THAY ĐỔI</button>
            </div>
        </form>
    </div>
</div>