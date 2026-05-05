<section class="card">
    <h2><?= htmlspecialchars($heading ?? 'Admin Dashboard', ENT_QUOTES, 'UTF-8') ?></h2>
    <hr>
    <div class="admin-nav-actions" style="padding: 20px 0; display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="admin/users" style="padding: 12px 20px; background-color: #4A90E2; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <span>👥</span> Quản lý danh sách User
        </a>

        <a href="admin/users/add" style="padding: 12px 20px; background-color: #27AE60; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <span>➕</span> Thêm người dùng mới
        </a>

        <a href="admin/settings/about" style="padding: 12px 20px; background-color: #F39C12; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <span>📝</span> Chỉnh sửa trang Giới thiệu
        </a>


        <a href="/whey_web/admin/faqs" style="padding: 12px 20px; background-color: #9B59B6; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px; transition: opacity 0.3s;">
            <span>❓</span> Quản lý câu hỏi (FAQ)
        </a>

    </div>
</section>