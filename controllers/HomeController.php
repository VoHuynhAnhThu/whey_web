<?php

declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
{
    $db = Database::connection();
    $settingModel = new SettingModel($db);
    
    // 1. Lấy mảng thô từ Database
    $rawSettings = $settingModel->getAllSettings(); 
    
    // 2. PHẢI định dạng lại mảng như thế này
    $settings = [];
    foreach ($rawSettings as $row) {
        $settings[$row['key']] = $row['value'];
    }

    $this->view('home', [
        'title' => 'FITWHEY - Thực phẩm thể hình chính hãng',
        'settings' => $settings
    ], 'main');
}

    public function about(): void
    {
        $db = Database::connection();
        $settingModel = new SettingModel($db);

        // Lấy tất cả cài đặt
        $rawSettings = $settingModel->getAllSettings();
        $aboutData = [];
        foreach ($rawSettings as $row) {
            // Chỉ lấy các key liên quan đến trang giới thiệu (bắt đầu bằng about_)
            if (str_starts_with($row['key'], 'about_')) {
                $aboutData[$row['key']] = $row['value'];
            }
        }

        $this->view('public/about', [
            'title' => $aboutData['about_title'] ?? 'Giới thiệu - FITWHEY',
            'about' => $aboutData
        ]);
    }

    public function faq(): void {
    $questionModel = new Question();
    $this->view('public/faq', [
        'title' => 'Hỏi đáp - FITWHEY',
        'questions' => $questionModel->getAllWithAnswers()
    ]);
}

    public function ask(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $questionModel = new Question();
        
        $currentUser = Auth::user(); 
        
        $data = [
            'title'   => $_POST['title'] ?? '',
            'body'    => $_POST['body'] ?? '',
            'user_id' => $currentUser ? $currentUser['id'] : null 
        ];

        if ($questionModel->create($data)) {
            header('Location: /whey_web/faq?status=success');
            exit;
        }
    }
} 

    public function contact(): void
    {
        $this->view('contact', [
            'title' => 'Liên hệ với FITWHEY',
            'success' => $_GET['success'] ?? null
        ]);
    }

    public function submitContact(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connection();
            $model = new ContactModel($db);

            $result = $model->create($_POST);

            if ($result) {
                // Chuyển hướng kèm tham số success=1 như code cũ của ông
                $this->redirect('/whey_web/contact?success=1');
            } else {
                $this->redirect('/whey_web/contact?error=1');
            }
        }
    }
}

