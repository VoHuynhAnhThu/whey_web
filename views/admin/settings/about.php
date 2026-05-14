<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Giới thiệu - FITWHEY</title>
    <link rel="stylesheet" href="/whey_web/assets/css/about.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
</head>
<body>
    <div class="admin-container">
        <div class="header-actions">
            <div class="title-group">
                <h1>Quản lý trang Giới thiệu</h1>
                <p class="subtitle">Chỉnh sửa nội dung hiển thị trên trang giới thiệu của FITWHEY</p>
            </div>
            <a href="/whey_web/about" target="_blank" class="btn-view-site">
                <i class="ti-eye"></i> Xem trang chủ
            </a>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert-success">
                <i class="ti-check"></i> Cập nhật nội dung thành công!
            </div>
        <?php endif; ?>

        <form action="/whey_web/admin/settings/about" method="POST" enctype="multipart/form-data" class="admin-form">
            
            <div class="form-section">
                <div class="form-group">
                    <label>Tiêu đề trang</label>
                    <input type="text" name="settings[about_title]" class="form-control" 
                           value="<?= htmlspecialchars($about['about_title'] ?? '') ?>" placeholder="Ví dụ: Welcome to FitWhey">
                </div>

                <div class="form-group">
                    <label>Nội dung chi tiết</label>
                    <textarea name="settings[about_content]" class="form-control" rows="8" placeholder="Viết câu chuyện về thương hiệu..."><?= htmlspecialchars($about['about_content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label>Ảnh minh họa (Nên dùng ảnh .jpg, .png)</label>
                    <div class="upload-wrapper">
                        <input type="file" name="about_image_file" class="form-control" accept="image/*">
                    </div>
                    
                    <?php if (!empty($about['about_image'])): ?>
                        <div class="image-preview-container">
                            <span class="preview-label">Ảnh đang hiển thị:</span>
                            <div class="image-box">
                                <?php 
                                    // Kiểm tra nếu là link web thì hiện thẳng, nếu là tên file thì nối đường dẫn nội bộ
                                    $image_path = $about['about_image'];
                                    if (!filter_var($image_path, FILTER_VALIDATE_URL)) {
                                        $image_path = "/whey_web/public/uploads/" . $image_path;
                                    }
                                ?>
                                <img src="<?= $image_path ?>" alt="About Image" onerror="this.src='/whey_web/assets/images/default-placeholder.png';">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="ti-save"></i> LƯU THAY ĐỔI
                </button>
            </div>
        </form>
    </div>
</body>
</html>