<?php

declare(strict_types=1);

class NewsController extends Controller
{
    private News $newsModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->newsModel = new News();
        $this->commentModel = new Comment();
    }

    /**
     * Trang danh sách bài viết
     */
    public function index(): void
    {
        $page = max(1, isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        if (!empty($keyword)) {
            $news = $this->newsModel->searchPublished($keyword, $perPage, $offset);
            $total = $this->newsModel->countSearchPublished($keyword);
        } else {
            $news = $this->newsModel->getAllPublished($perPage, $offset);
            $total = $this->newsModel->countPublished();
        }

        $totalPages = ceil($total / $perPage);

        $this->view('news/index', [
            'news' => $news,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }

    /**
     * Trang chi tiết bài viết
     */
    public function show(): void
    {
        $slug = $_GET['slug'] ?? null;

        if (!$slug) {
            http_response_code(404);
            $this->view('errors/404', ['title' => '404 Not Found']);
            return;
        }

        $news = $this->newsModel->findBySlug($slug);

        if (!$news) {
            http_response_code(404);
            $this->view('errors/404', ['title' => '404 Not Found']);
            return;
        }

        // Cập nhật lượt xem
        $this->newsModel->incrementViewCount($news['id']);

        $page = max(1, isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $comments = $this->commentModel->getApprovedComments($news['id'], $perPage, $offset);
        $totalComments = $this->commentModel->countApprovedComments($news['id']);
        $totalPages = ceil($totalComments / $perPage);

        $this->view('news/show', [
            'news' => $news,
            'comments' => $comments,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalComments' => $totalComments,
        ]);
    }

    /**
     * Thêm bình luận
     */
    public function addComment(): void
    {
        $this->requireAuth();

        $newsId = $_POST['news_id'] ?? null;
        $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
        $content = isset($_POST['content']) ? trim((string) $_POST['content']) : '';

        if (!$newsId || $content === '') {
            Session::flash('error', 'Vui lòng điền đầy đủ thông tin.');
            // $this->redirect('/whey_web/news?slug=' . ($_POST['slug'] ?? ''));
            return;
        }

        if ($rating < 0 || $rating > 5) {
            Session::flash('error', 'Đánh giá không hợp lệ.');
            // $this->redirect('/whey_web/news?slug=' . ($_POST['slug'] ?? ''));
            return;
        }

        if (mb_strlen($content) > 2000) {
            Session::flash('error', 'Bình luận không được vượt quá 2000 ký tự.');
            // $this->redirect('/whey_web/news?slug=' . ($_POST['slug'] ?? ''));
            return;
        }

        $news = $this->newsModel->findById($newsId);
        if (!$news || ($news['status'] ?? '') !== 'published') {
            Session::flash('error', 'Bài viết không tồn tại.');
            $this->redirect('/whey_web/news');
            return;
        }

        $this->commentModel->create([
            'news_id' => $newsId,
            'user_id' => Auth::id(),
            'rating' => $rating,
            'content' => $content,
        ]);

        Session::flash('success', 'Bình luận của bạn đã được gửi.');
        $this->redirect('/whey_web/news/detail?slug=' . $news['slug']);
    }
}
