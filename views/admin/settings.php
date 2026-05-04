<?php include 'header.php'; ?>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Cấu hình thông tin Website</h4>
                <p class="text-muted font-14 mb-4">Thay đổi thông tin liên hệ và giới thiệu chung của công ty tại đây.</p>
                
                <form action="/whey_web/admin/update-settings" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group mb-3">
                        <label for="phone" class="col-form-label">Số điện thoại công ty</label>
                        <!-- Bảo mật: Dùng htmlspecialchars khi hiển thị dữ liệu từ DB -->
                        <input class="form-control" type="text" name="site_phone" 
                            value="<?php echo htmlspecialchars($settings['site_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="address" class="col-form-label">Địa chỉ công ty</label>
                        <input class="form-control" type="text" name="site_address" 
                             value="<?php echo htmlspecialchars($settings['site_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="intro" class="col-form-label">Đoạn giới thiệu ngắn (Trang chủ)</label>
                        <textarea class="form-control" name="site_intro" rows="4"><?php echo htmlspecialchars($settings['site_intro'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="col-form-label">Logo website hiện tại</label>
                        <div class="mb-3 p-2 border inline-block" style="width: fit-content; background: #f8f9fa;">
                            <?php if (!empty($settings['site_logo'])): ?>
                                <!-- Sửa đường dẫn: Nối folder uploads với tên file lưu trong DB -->
                                <img src="/whey_web/public/uploads/<?php echo htmlspecialchars($settings['site_logo'], ENT_QUOTES, 'UTF-8'); ?>" width="150" alt="Current Logo">
                            <?php else: ?>
                                <p class="text-danger">Chưa có logo</p>
                            <?php endif; ?>
                        </div>
                        <input class="form-control" type="file" name="site_logo" accept="image/*">
                        <small class="text-secondary font-italic">Chỉ chấp nhận file .jpg, .png, .webp. Dung lượng tối đa 2MB.</small>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>