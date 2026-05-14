<?php

declare(strict_types=1);

class AdminNewsController extends Controller
{
    private News $newsModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->newsModel = new News();
        $this->commentModel = new Comment();
    }

    /**
     * Dashboard quản lý tin tức
     */
    public function newsList(): void
    {
        $this->requireRole('admin');

        $page = max(1, isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        if (!empty($keyword)) {
            $news = $this->newsModel->search($keyword, $perPage, $offset);
            $total = $this->newsModel->countSearch($keyword);
        } else {
            $news = $this->newsModel->getAll($perPage, $offset);
            $total = $this->newsModel->count();
        }

        $totalPages = ceil($total / $perPage);

        $this->view('admin/news/list', [
            'title' => 'Quản lý Tin tức - FITWHEY',
            'news' => $news,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ], 'admin');
    }

    /**
     * Form tạo bài viết mới
     */
    public function createForm(): void
    {
        $this->requireRole('admin');
        $this->view('admin/news/create', [
            'title' => 'Tạo bài viết - FITWHEY',
        ], 'admin');
    }

    /**
     * Xử lý tạo bài viết mới
     */
    public function store(): void
    {
        $this->requireRole('admin');

        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $content = $_POST['content'] ?? null;
        $status = $_POST['status'] ?? 'draft';
        $allowedStatuses = ['draft', 'published'];

        $title = is_string($title) ? trim($title) : null;
        $description = is_string($description) ? trim($description) : null;
        $content = is_string($content) ? trim($content) : null;

        if (!$title || !$content) {
            Session::flash('error', 'Tiêu đề và nội dung không được để trống.');
            $this->redirect('/whey_web/admin/news/create');
            return;
        }

        if (mb_strlen($title) > 255) {
            Session::flash('error', 'Tiêu đề không được vượt quá 255 ký tự.');
            $this->redirect('/whey_web/admin/news/create');
            return;
        }

        if ($description !== null && mb_strlen($description) > 1000) {
            Session::flash('error', 'Mô tả ngắn không được vượt quá 1000 ký tự.');
            $this->redirect('/whey_web/admin/news/create');
            return;
        }

        if (!in_array($status, $allowedStatuses, true)) {
            Session::flash('error', 'Trạng thái bài viết không hợp lệ.');
            $this->redirect('/whey_web/admin/news/create');
            return;
        }

        $slug = $this->generateUniqueSlug($title);

        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['featured_image']['error'] !== UPLOAD_ERR_OK) {
                Session::flash('error', 'Tệp ảnh tải lên không hợp lệ.');
                $this->redirect('/whey_web/admin/news/create');
                return;
            }

            $featuredImage = $this->uploadImage($_FILES['featured_image']);
            if ($featuredImage === null) {
                Session::flash('error', 'Ảnh đại diện không hợp lệ. Chỉ chấp nhận JPG, PNG, WebP dưới 5MB.');
                $this->redirect('/whey_web/admin/news/create');
                return;
            }
        }

        $this->newsModel->create([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'featured_image' => $featuredImage,
            'author_id' => Auth::id(),
            'status' => $status,
        ]);

        Session::flash('success', 'Bài viết đã được tạo thành công.');
        $this->redirect('/whey_web/admin/news');
    }

    /**
     * Form chỉnh sửa bài viết
     */
    public function editForm(): void
    {
        $this->requireRole('admin');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/whey_web/admin/news');
            return;
        }

        $news = $this->newsModel->findById($id);
        if (!$news) {
            Session::flash('error', 'Bài viết không tồn tại.');
            $this->redirect('/whey_web/admin/news');
            return;
        }

        $this->view('admin/news/edit', [
            'title' => 'Chỉnh sửa bài viết - FITWHEY',
            'news' => $news,
        ], 'admin');
    }

    /**
     * Xử lý chỉnh sửa bài viết
     */
    public function update(): void
    {
        $this->requireRole('admin');

        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $content = $_POST['content'] ?? null;
        $status = $_POST['status'] ?? 'draft';
        $allowedStatuses = ['draft', 'published'];

        $title = is_string($title) ? trim($title) : null;
        $description = is_string($description) ? trim($description) : null;
        $content = is_string($content) ? trim($content) : null;

        if (!$id || !$title || !$content) {
            Session::flash('error', 'Tiêu đề và nội dung không được để trống.');
            $this->redirect('/whey_web/admin/news/edit?id=' . $id);
            return;
        }

        if (mb_strlen($title) > 255) {
            Session::flash('error', 'Tiêu đề không được vượt quá 255 ký tự.');
            $this->redirect('/whey_web/admin/news/edit?id=' . $id);
            return;
        }

        if ($description !== null && mb_strlen($description) > 1000) {
            Session::flash('error', 'Mô tả ngắn không được vượt quá 1000 ký tự.');
            $this->redirect('/whey_web/admin/news/edit?id=' . $id);
            return;
        }

        if (!in_array($status, $allowedStatuses, true)) {
            Session::flash('error', 'Trạng thái bài viết không hợp lệ.');
            $this->redirect('/whey_web/admin/news/edit?id=' . $id);
            return;
        }

        $news = $this->newsModel->findById($id);
        if (!$news) {
            Session::flash('error', 'Bài viết không tồn tại.');
            $this->redirect('/whey_web/admin/news');
            return;
        }

        $slug = $this->generateUniqueSlug($title, $id);
        $featuredImage = $news['featured_image'];

        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['featured_image']['error'] !== UPLOAD_ERR_OK) {
                Session::flash('error', 'Tệp ảnh tải lên không hợp lệ.');
                $this->redirect('/whey_web/admin/news/edit?id=' . $id);
                return;
            }

            $newImage = $this->uploadImage($_FILES['featured_image']);
            if ($newImage === null) {
                Session::flash('error', 'Ảnh đại diện không hợp lệ. Chỉ chấp nhận JPG, PNG, WebP dưới 5MB.');
                $this->redirect('/whey_web/admin/news/edit?id=' . $id);
                return;
            }

            // Xóa ảnh cũ
            if ($news['featured_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $news['featured_image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $news['featured_image']);
            }
            $featuredImage = $newImage;
        }

        $this->newsModel->update($id, [
            'author_id' => Auth::id(),
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'featured_image' => $featuredImage,
            'status' => $status,
        ]);

        Session::flash('success', 'Bài viết đã được cập nhật thành công.');
        $this->redirect('/whey_web/admin/news');
    }

    /**
     * Xóa bài viết
     */
    public function delete(): void
    {
        $this->requireRole('admin');

        $id = $_POST['id'] ?? null;
        if (!$id) {
            Session::flash('error', 'ID không hợp lệ.');
            $this->redirect('/whey_web/admin/news');
            return;
        }

        $news = $this->newsModel->findById($id);
        if (!$news) {
            Session::flash('error', 'Bài viết không tồn tại.');
            $this->redirect('/whey_web/admin/news');
            return;
        }

        // Xóa ảnh
        if ($news['featured_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $news['featured_image'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $news['featured_image']);
        }

        $this->newsModel->delete($id);

        Session::flash('success', 'Bài viết đã được xóa thành công.');
        $this->redirect('/whey_web/admin/news');
    }

    /**
     * Danh sách bình luận
     */
    public function commentsList(): void
    {
        $this->requireRole('admin');

        $page = max(1, isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $status = $_GET['status'] ?? 'all';
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        if (!empty($keyword)) {
            $comments = $this->commentModel->search($keyword, $perPage, $offset);
            $total = $this->commentModel->countSearch($keyword);
        } elseif ($status !== 'all') {
            $comments = $this->commentModel->getByStatus($status, $perPage, $offset);
            $total = $this->commentModel->countByStatus($status);
        } else {
            $comments = $this->commentModel->getAll($perPage, $offset);
            $total = $this->commentModel->count();
        }

        $totalPages = ceil($total / $perPage);

        $this->view('admin/comments/list', [
            'title' => 'Quản lý Bình luận - FITWHEY',
            'comments' => $comments,
            'status' => $status,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ], 'admin');
    }

    /**
     * Duyệt bình luận
     */
    // public function approveComment(): void
    // {
    //     $this->requireRole('admin');

    //     $id = $_POST['id'] ?? null;
    //     if (!$id) {
    //         Session::flash('error', 'ID không hợp lệ.');
    //         $this->redirect('/whey_web/admin/comments');
    //         return;
    //     }

    //     $comment = $this->commentModel->findById($id);
    //     if (!$comment) {
    //         Session::flash('error', 'Bình luận không tồn tại.');
    //         $this->redirect('/whey_web/admin/comments');
    //         return;
    //     }

    //     $this->commentModel->updateStatus($id, 'approved');

    //     Session::flash('success', 'Bình luận đã được duyệt.');
    //     $this->redirect('/whey_web/admin/comments');
    // }

    /**
     * Từ chối bình luận
     */
    // public function rejectComment(): void
    // {
    //     $this->requireRole('admin');

    //     $id = $_POST['id'] ?? null;
    //     if (!$id) {
    //         Session::flash('error', 'ID không hợp lệ.');
    //         $this->redirect('/whey_web/admin/comments');
    //         return;
    //     }

    //     $comment = $this->commentModel->findById($id);
    //     if (!$comment) {
    //         Session::flash('error', 'Bình luận không tồn tại.');
    //         $this->redirect('/whey_web/admin/comments');
    //         return;
    //     }

    //     $this->commentModel->updateStatus($id, 'rejected');

    //     Session::flash('success', 'Bình luận đã bị từ chối.');
    //     $this->redirect('/whey_web/admin/comments');
    // }

    /**
     * Xóa bình luận
     */
    public function deleteComment(): void
    {
        $this->requireRole('admin');

        $id = $_POST['id'] ?? null;
        if (!$id) {
            Session::flash('error', 'ID không hợp lệ.');
            $this->redirect('/whey_web/admin/comments');
            return;
        }

        $comment = $this->commentModel->findById($id);
        if (!$comment) {
            Session::flash('error', 'Bình luận không tồn tại.');
            $this->redirect('/whey_web/admin/comments');
            return;
        }

        $this->commentModel->delete($id);

        Session::flash('success', 'Bình luận đã được xóa.');
        $this->redirect('/whey_web/admin/comments');
    }

    /**
     * Helper: Tạo slug từ tiêu đề
     */
    private function generateSlug(string $title): string
    {
        $slug = trim(mb_strtolower($title));
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug) ?: $slug;
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
        $slug = trim($slug, '-');

        return $slug !== '' ? $slug : 'bai-viet';
    }

    /**
     * Helper: Tạo slug duy nhất
     */
    private function generateUniqueSlug(string $title, ?string $ignoreId = null): string
    {
        $baseSlug = $this->generateSlug($title);
        $slug = $baseSlug;
        $suffix = 2;

        while ($this->newsModel->slugExists($slug, $ignoreId)) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * Helper: Upload ảnh
     */
    private function uploadImage(array $file): ?string
    {
        $maxSize = 5 * 1024 * 1024;
        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        if (($file['size'] ?? 0) <= 0 || $file['size'] > $maxSize) {
            return null;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!isset($allowedMimeTypes[$mimeType])) {
            return null;
        }

        $uploadDir = '/whey_web/uploads/news/';
        $fullDir = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

        if (!is_dir($fullDir)) {
            mkdir($fullDir, 0755, true);
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $allowedMimeTypes[$mimeType];
        $filepath = $fullDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $uploadDir . $filename;
        }

        return null;
    }
}
