<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/whey_web/assets/css/about.css">
</head>
<body>
    <div class="admin-container">
        <h1>Chỉnh sửa trang Giới thiệu</h1>
        <form action="/whey_web/admin/settings/about" method="POST">
            <div class="form-group">
                <label>Tiêu đề trang:</label>
                <input type="text" name="settings[about_title]" 
                    value="<?= htmlspecialchars($about['about_title'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Nội dung giới thiệu:</label>
                <textarea name="settings[about_content]" rows="10" class="form-control"><?= htmlspecialchars($about['about_content'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Đường dẫn ảnh:</label>
                <input type="text" name="settings[about_image]" 
                    value="<?= htmlspecialchars($about['about_image'] ?? '') ?>" class="form-control">
            </div>

            <button type="submit" class="btn-save">Lưu thay đổi</button>
        </form>
    </div>    
</body>
</html>