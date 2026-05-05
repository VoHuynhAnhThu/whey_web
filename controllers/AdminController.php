<?php

declare(strict_types=1);

class AdminController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->requireRole('admin');
        $this->userModel = new User();
    }

    public function dashboard(): void
    {
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - FITWHEY',
            'heading' => 'Admin Dashboard Placeholder',
        ]);
    }

    public function index()
    {
        $allUsers = $this->userModel->getAll();
        
        return $this->view('admin/users/index', [
            'users' => $allUsers,
            'title' => 'Quản lý người dùng'
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($email, $passwordHash, $role);
            header('Location: /whey_web/admin/users/add');
            exit;
        }

        return $this->view('admin/users/add', ['title' => 'Thêm người dùng mới']);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $this->userModel->delete($id);
        }
        header('Location: /whey_web/admin/users');
        exit;
    }

    public function edit() 
    {
        $id = $_GET['id'] ?? '';
        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /admin/users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->userModel->updateAccount($id, $data);
            header('Location: /whey_web/admin/users');
            exit;
        }

        return $this->view('/admin/users/edit', ['user' => $user]);
    }

    public function editAbout(): void
    {
        $settingModel = new Settings();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingsData = $_POST['settings'] ?? [];

            foreach ($settingsData as $key => $value) {
                $settingModel->updateValue($key, $value);
            }
            header('Location: /whey_web/admin/settings/about?status=success');
            exit;
        }

        $aboutData = $settingModel->getByPage('about');

        $this->view('admin/settings/about', [
            'title' => 'Quản lý trang Giới thiệu - FITWHEY',
            'about' => $aboutData
        ]);
    }

    public function manageFaqs(): void {
    $questionModel = new Question();
    $this->view('admin/faqs/index', [
        'title' => 'Quản lý câu hỏi',
        'questions' => $questionModel->getAllWithAnswers()
    ]);
}

    public function replyFaq(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $answerModel = new Answer();
            $answerModel->create([
                'question_id' => $_POST['question_id'],
                'user_id' => $_SESSION['user_id'],
                'body' => $_POST['answer_body']
            ]);
            header('Location: /whey_web/admin/faqs?status=replied');
            exit;
        }
    }

    public function showReplyForm(): void {
    $id = $_GET['id'] ?? '';
    $questionModel = new Question();
    $question = $questionModel->getById($id);

    if (!$question) {
        header('Location: /whey_web/admin/faqs');
        exit;
    }

    $this->view('admin/faqs/reply', [
        'title' => 'Phản hồi câu hỏi',
        'question' => $question
    ]);
}
}