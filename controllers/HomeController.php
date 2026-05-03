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
        'settings' => $settings // <--- Giờ thì View mới hiểu được $settings['site_phone']
    ]);
}

    public function about(): void
    {
        $this->view('public/about', [
            'title' => 'About - FITWHEY',
            'heading' => 'About This Project',
        ]);
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
                // Chuyển hướng kèm thông báo thành công
                $this->redirect('/whey_web/contact?success=1');
            }
        }
    }
}

