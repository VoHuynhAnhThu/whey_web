<section class="admin-dashboard">
    <div class="admin-dashboard__hero">
        <h2><?= htmlspecialchars($heading ?? 'Admin Dashboard', ENT_QUOTES, 'UTF-8') ?></h2>
        <p>Quản lý tin tức, bình luận và nội dung hệ thống theo phong cách FITWHEY.</p>
    </div>

    <div class="admin-dashboard__grid">
        <div class="admin-stat-card">
            <span>Tin tức</span>
            <strong>Quản lý bài viết</strong>
        </div>
        <div class="admin-stat-card">
            <span>Bình luận</span>
            <strong>Duyệt nội dung</strong>
        </div>
        <div class="admin-stat-card">
            <span>Liên hệ</span>
            <strong>Hỗ trợ khách hàng</strong>
        </div>
        <div class="admin-stat-card">
            <span>Giao diện</span>
            <strong>Tùy chỉnh layout</strong>
        </div>
    </div>

    <div class="admin-dashboard__panel"></div>
    <hr>
    <div class="admin-nav-actions" style="padding: 20px 0; display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="admin/users" style="padding: 12px 20px; background-color: #4A90E2; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <span>👥</span> Quản lý danh sách User
        </a>

        <a href="admin/users/add" style="padding: 12px 20px; background-color: #27AE60; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
            <span>➕</span> Thêm người dùng mới
        </a>

    </div>
</section>