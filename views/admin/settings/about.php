<style>
    .admin-card { border-radius: 20px; background: #fff; border: 1px solid #eee; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .fit-input { background: #F3F4F6 !important; border: 2px solid transparent !important; border-radius: 12px !important; padding: 12px 20px; width: 100%; outline: none; transition: 0.3s; margin-top: 8px; }
    .fit-input:focus { border-color: #10B981 !important; background: #fff !important; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.1); }
    .btn-fit-primary { background-color: #10B981; color: white; border: none; border-radius: 12px; font-weight: 700; transition: 0.3s; cursor: pointer; padding: 15px 40px; }
    .btn-fit-primary:hover { background-color: #0d9468; transform: translateY(-2px); }
    .form-label { font-weight: 700; color: #374151; margin-bottom: 0; display: block; }
    .status-alert { border-radius: 12px; padding: 15px; margin-bottom: 20px; font-weight: 600; }
</style>

<div class="container-fluid py-4">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h2 class="fw-bold m-0">QUẢN LÝ TRANG <span style="color: #10B981;">GIỚI THIỆU</span></h2>
        <a href="/whey_web/about" target="_blank" class="btn btn-outline-secondary" style="border-radius: 10px;">
            <i class="ti-eye"></i> Xem trang chủ
        </a>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success status-alert shadow-sm">
            <i class="ti-check-box"></i> Đã cập nhật nội dung trang giới thiệu thành công!
        </div>
    <?php endif; ?>

    <div class="admin-card">
        <form action="/whey_web/admin/settings/about" method="POST">
            <h5 class="fw-bold mb-4" style="border-left: 5px solid #10B981; padding-left: 15px;">Chỉnh sửa nội dung chi tiết</h5>
            
            <div class="mb-4">
                <label class="form-label">Tiêu đề trang giới thiệu</label>
                <input type="text" name="settings[about_title]" class="fit-input" 
                       value="<?= htmlspecialchars($about['about_title'] ?? '') ?>" placeholder="Ví dụ: Chào mừng đến với FITWHEY">
            </div>

            <div class="mb-4">
                <label class="form-label">Nội dung giới thiệu chi tiết</label>
                <textarea name="settings[about_content]" class="fit-input" rows="10" placeholder="Viết câu chuyện về thương hiệu của bạn tại đây..."><?= htmlspecialchars($about['about_content'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Đường dẫn ảnh minh họa (URL hoặc tên file)</label>
                    <input type="text" name="settings[about_image]" class="fit-input" 
                           value="<?= htmlspecialchars($about['about_image'] ?? '') ?>" placeholder="about_bg.jpg">
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label">Câu slogan / Trích dẫn</label>
                    <input type="text" name="settings[about_slogan]" class="fit-input" 
                           value="<?= htmlspecialchars($about['about_slogan'] ?? '') ?>" placeholder="Sức khỏe của bạn là niềm tự hào của chúng tôi">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-fit-primary shadow">LƯU THAY ĐỔI</button>
            </div>
        </form>
    </div>
</div>