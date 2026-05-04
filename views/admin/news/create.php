<div class="admin-form-container">
    <div class="form-header">
        <h1>Tạo bài viết mới</h1>
        <a href="/whey_web/admin/news" class="btn btn-secondary">← Quay lại</a>
    </div>

    <form method="POST" action="/whey_web/admin/news" class="admin-form" enctype="multipart/form-data" id="newsForm">
        <div class="form-section">
            <h2>Thông tin cơ bản</h2>

            <div class="form-group">
                <label for="title">Tiêu đề *</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Nhập tiêu đề bài viết"
                    required maxlength="255">
            </div>

            <div class="form-group">
                <label for="description">Mô tả ngắn</label>
                <textarea id="description" name="description" class="form-control" rows="3"
                    placeholder="Nhập mô tả ngắn (hiển thị trên danh sách)" maxlength="1000"></textarea>
                <small>Tối đa 1000 ký tự</small>
            </div>

            <div class="form-group">
                <label for="content">Nội dung *</label>
                <textarea id="content" name="content" class="form-control wysiwyg-editor" rows="10"
                    placeholder="Nhập nội dung bài viết" required></textarea>
                <small>Hỗ trợ HTML và Markdown</small>
            </div>
        </div>

        <div class="form-section">
            <h2>Hình ảnh & Trạng thái</h2>

            <div class="form-group">
                <label for="featured_image">Ảnh đại diện</label>
                <div class="file-input-wrapper">
                    <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
                    <small>Định dạng: JPG, PNG (Tối đa 5MB)</small>
                </div>
                <div id="imagePreview" class="image-preview" style="display: none;">
                    <img id="previewImg" src="" alt="Xem trước ảnh">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">Xóa ảnh</button>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft">Bản nháp</option>
                    <option value="published" selected>Đã xuất bản</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">Tạo bài viết</button>
            <a href="/whey_web/admin/news" class="btn btn-secondary btn-large">Hủy</a>
        </div>

        <input type="hidden" id="metaTitle" name="meta_title" value="">
        <input type="hidden" id="metaDescription" name="meta_description" value="">
        <input type="hidden" id="metaKeywords" name="meta_keywords" value="">
    </form>
</div>

<script>
    // Preview image
    document.getElementById('featured_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('previewImg').src = event.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    function removeImage() {
        document.getElementById('featured_image').value = '';
        document.getElementById('imagePreview').style.display = 'none';
    }

    // Form validation
    document.getElementById('newsForm').addEventListener('submit', function (e) {
        const title = document.getElementById('title').value.trim();
        const content = document.getElementById('content').value.trim();

        if (!title || !content) {
            e.preventDefault();
            alert('Vui lòng điền tiêu đề và nội dung!');
            return false;
        }

        // Set meta tags from title and description
        document.getElementById('metaTitle').value = title;
        document.getElementById('metaDescription').value = document.getElementById('description').value;
    });
</script>

<style>
    .admin-form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .form-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
    }

    .admin-form {
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
    }

    .form-section {
        margin-bottom: 40px;
    }

    .form-section h2 {
        font-size: 1.3rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0066cc;
        color: #333;
    }

    .form-section:last-of-type {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.2);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    textarea.wysiwyg-editor {
        min-height: 400px;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-size: 0.95rem;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-wrapper small {
        display: block;
        margin-top: 8px;
        color: #999;
    }

    .image-preview {
        margin-top: 15px;
        padding: 15px;
        border: 2px dashed #0066cc;
        border-radius: 4px;
    }

    .image-preview img {
        max-width: 300px;
        max-height: 300px;
        border-radius: 4px;
        margin-bottom: 10px;
        display: block;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 1rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #0066cc;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0052a3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-large {
        padding: 12px 32px;
        font-size: 1rem;
    }

    small {
        display: block;
        margin-top: 5px;
        color: #999;
    }

    @media (max-width: 768px) {
        .admin-form-container {
            padding: 15px;
        }

        .admin-form {
            padding: 20px;
        }

        .form-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>