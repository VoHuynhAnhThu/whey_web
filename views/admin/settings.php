<?php include 'header.php'; ?>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Cấu hình thông tin Website</h4>
                <p class="text-muted font-14 mb-4">Thay đổi thông tin liên hệ và giới thiệu chung của công ty tại đây.</p>
                
                <!-- Action trỏ về route xử lý update trong AdminController -->
                <form action="/whey_web/admin/update-settings" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group mb-3">
                        <label for="phone" class="col-form-label">Số điện thoại công ty</label>
                        <!-- Dùng cú pháp ?? '' để tránh lỗi nếu key không tồn tại trong DB -->
                        <input class="form-control" type="text" name="site_phone" 
                            value="<?php echo $settings['site_phone'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="address" class="col-form-label">Địa chỉ công ty</label>
                        <input class="form-control" type="text" name="site_address" 
                             value="<?php echo $settings['site_address'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="intro" class="col-form-label">Đoạn giới thiệu ngắn (Trang chủ)</label>
                        <textarea class="form-control" name="site_intro" rows="4"><?php echo $settings['site_intro'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="col-form-label">Logo website hiện tại</label>
                        <div class="mb-3 p-2 border inline-block" style="width: fit-content; background: #f8f9fa;">
                            <!-- Hiển thị ảnh từ đường dẫn lưu trong DB -->
                            <?php if (!empty($settings['site_logo'])): ?>
                                <img src="<?php echo $settings['site_logo']; ?>" width="150" alt="Current Logo">
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