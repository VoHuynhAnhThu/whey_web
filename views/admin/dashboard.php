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
</section>