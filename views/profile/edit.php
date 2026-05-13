<section class="profile-page py-5">
    <div class="container">
        <div class="mb-5">
            <h2 class="fw-bold">HỒ SƠ <span style="color: var(--fit-primary);">CÁ NHÂN</span></h2>
            <p class="text-muted">Quản lý thông tin tài khoản và bảo mật của ông tại FITWHEY.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 shadow-sm text-center" style="border-radius: 20px; background: #fff; border: 1px solid #eee;">
                    <div class="profile-avatar-container mb-3" style="width: 180px; height: 180px; margin: 0 auto; overflow: hidden; border-radius: 50%; border: 5px solid #f3f4f6;">
                        <img src="<?= htmlspecialchars($currentUser['avatar'] ?? '/whey_web/public/images/default-avatar.png') ?>" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($currentUser['name'] ?? 'Chí Thanh') ?></h5>
                    <p class="text-muted small mb-4"><?= htmlspecialchars($currentUser['email'] ?? '') ?></p>
                    
                    <label for="avatar-upload" class="btn btn-outline-success w-100 style="border-radius: 12px; cursor: pointer;">
                        <i class="bi bi-camera me-2"></i> Đổi ảnh đại diện
                    </label>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="p-4 p-md-5 shadow-sm" style="border-radius: 20px; background: #fff; border: 1px solid #eee;">
                    <form action="/whey_web/profile/update" method="POST" enctype="multipart/form-data">
                        <input type="file" id="avatar-upload" name="avatar" class="d-none">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Họ và Tên</label>
                                <input type="text" name="name" class="fit-input" value="<?= htmlspecialchars($currentUser['name'] ?? '') ?>" placeholder="Nhập tên của ông">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Email (Không thể sửa)</label>
                                <input type="email" class="fit-input" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" readonly style="background: #f8f9fa !important;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="fit-input" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Địa chỉ</label>
                                <input type="text" name="address" class="fit-input" value="<?= htmlspecialchars($currentUser['address'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Giới thiệu bản thân</label>
                            <textarea name="bio" class="fit-input" rows="4"><?= htmlspecialchars($currentUser['bio'] ?? '') ?></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn-fit-primary py-3 px-5 shadow">
                                LƯU CẬP NHẬT <i class="bi bi-check2-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>