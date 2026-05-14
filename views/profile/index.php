<style>
    /* CSS để làm đẹp các thành phần trong trang cá nhân */
    .profile-card { border-radius: 20px; background: #fff; border: 1px solid #eee; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .avatar-wrapper { position: relative; width: 150px; height: 150px; margin: 0 auto 20px; }
    .avatar-img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #F3F4F6; }
    .form-label { font-weight: 700; color: #374151; margin-bottom: 8px; display: block; }
    
    /* Lớp CSS cho ô nhập liệu giống Figma */
    .fit-input { background: #F3F4F6; border: 1px solid transparent; border-radius: 12px; padding: 12px 15px; width: 100%; outline: none; transition: 0.3s; }
    .fit-input:focus { border-color: #10B981; background: #fff; }
    
    /* Lớp CSS cho nút bấm màu xanh lá */
    .btn-fit-primary { background-color: #10B981; color: white; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; transition: 0.3s; cursor: pointer; }
    .btn-fit-primary:hover { background-color: #0d9468; transform: translateY(-2px); }
</style>

<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold m-0">HỒ SƠ <span style="color: #10B981;">CÁ NHÂN</span></h2>
        <p class="text-muted">Quản lý thông tin tài khoản và bảo mật của ông tại FITWHEY.</p>
    </div>

    <form action="/whey_web/profile" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-4 text-center">
                <div class="profile-card">
                    <div class="avatar-wrapper">
                        <img src="<?= !empty($user['avatar_url'])
                            ? '/whey_web/public' . $user['avatar_url']
                            : '/whey_web/assets/images/default-avatar.png' ?>"
                            alt="Avatar" class="avatar-img">
                    </div>
                    <h4 class="fw-bold mb-3"><?= htmlspecialchars($user['full_name'] ?? 'Chí Thanh') ?></h4>
                    <input type="file" name="avatar" class="d-none" id="avatarInput">
                    <button type="button" class="btn btn-outline-secondary w-100" style="border-radius: 12px;" onclick="document.getElementById('avatarInput').click()">
                        <i class="bi bi-camera me-2"></i> Đổi ảnh đại diện
                    </button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="profile-card">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="full_name" class="fit-input" 
                                   value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" placeholder="Nhập tên của ông">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email (Không thể sửa)</label>
                            <input type="email" class="fit-input" style="background-color: #e9ecef !important;" 
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="fit-input" 
                                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="10111">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" class="fit-input" 
                                   value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="223 phạm văn thuận">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Giới thiệu bản thân</label>
                        <textarea name="bio" class="fit-input" rows="4"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-fit-primary shadow-sm">
                            LƯU CẬP NHẬT <i class="bi bi-check2-circle ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>