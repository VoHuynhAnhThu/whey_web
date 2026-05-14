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
        // Lấy ID của người đang đăng nhập
        $adminId = (string) Auth::id();
        
        // Lấy thông tin chi tiết (bao gồm full_name từ Profiles)
        $currentAdmin = $this->userModel->findById($adminId);

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - FITWHEY',
            'admin' => $currentAdmin, // Gửi dữ liệu admin sang View
        ], 'admin');
    }

    // Trang Cài đặt chung (Logo, Hotline, Địa chỉ)
    public function settings(): void
    {
        $db = Database::connection(); 
        $settingModel = new SettingModel($db); 

        $rawSettings = $settingModel->getAllSettings(); 
        $settings = [];
        foreach ($rawSettings as $row) {
            $settings[$row['key']] = $row['value'];
        }

        $this->view('admin/settings', [
            'title' => 'Cài đặt hệ thống - FITWHEY',
            'settings' => $settings 
        ], 'admin');
    }

    // Xử lý cập nhật Cài đặt chung
    public function updateSettings(): void 
    {
        $db = Database::connection();
        $model = new SettingModel($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                if (str_starts_with($key, 'site_')) {
                    $cleanValue = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                    $model->updateSetting($key, $cleanValue);
                }
            }

            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['site_logo']['tmp_name'];
                $fileName = $_FILES['site_logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'logo_' . time() . '.' . $fileExtension;
                    $uploadFileDir = './public/uploads/';
                    $dest_path = $uploadFileDir . $newFileName;

                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $model->updateSetting('site_logo', $newFileName);
                    }
                }
            }
            
            $this->redirect('/whey_web/admin/settings');
        }
    }

    // FIX: Bổ sung lại hàm chỉnh sửa trang Giới thiệu (About)
    public function editAbout(): void
    {
        $db = Database::connection();
        $settingModel = new SettingModel($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingsData = $_POST['settings'] ?? [];
            foreach ($settingsData as $key => $value) {
                $settingModel->updateSetting($key, $value);
            }
            $this->redirect('/whey_web/admin/settings/about?status=success');
        }

        $rawSettings = $settingModel->getAllSettings();
        $aboutData = [];
        foreach ($rawSettings as $row) {
            // Lọc ra các key bắt đầu bằng about_
            if (str_starts_with($row['key'], 'about_')) {
                $aboutData[$row['key']] = $row['value'];
            }
        }

        $this->view('admin/settings/about', [
            'title' => 'Quản lý trang Giới thiệu - FITWHEY',
            'about' => $aboutData
        ], 'admin');
    }

    // Quản lý liên hệ của khách hàng
    public function listContacts(): void
    {
        $db = Database::connection();
        $model = new ContactModel($db);
        
        $limit = 5; 
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        
        $offset = ($page - 1) * $limit;
        $totalContacts = $model->countAll();
        $totalPages = ceil($totalContacts / $limit);
        $contacts = $model->getPaginatedContacts($limit, $offset);

        $this->view('admin/contacts/index', [
            'title' => 'Quản lý liên hệ - FITWHEY',
            'contacts' => $contacts,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ], 'admin');
    }

    // Quản lý FAQ
    public function manageFaqs(): void 
    {
        $questionModel = new Question();
        $this->view('admin/faqs/index', [
            'title' => 'Quản lý câu hỏi',
            'questions' => $questionModel->getAllWithAnswers()
        ], 'admin');
    }

    public function replyFaq(): void 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $answerModel = new Answer();
            $answerModel->create([
                'question_id' => $_POST['question_id'],
                'user_id' => $_SESSION['user_id'] ?? null,
                'body' => $_POST['answer_body']
            ]);
            $this->redirect('/whey_web/admin/faqs?status=replied');
        }
    }

    public function showReplyForm(): void 
    {
        $id = $_GET['id'] ?? '';
        $questionModel = new Question();
        $question = $questionModel->getById($id);

        if (!$question) {
            $this->redirect('/whey_web/admin/faqs');
        }

        $this->view('admin/faqs/reply', [
            'title' => 'Phản hồi câu hỏi',
            'question' => $question
        ], 'admin');
    }

    public function updateContactStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? 'read';
            $db = Database::connection();
            $model = new ContactModel($db);
            $model->updateStatus((int)$id, $status);
            $this->redirect('/whey_web/admin/contacts');
        }
    }

    public function deleteContact(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $db = Database::connection();
            $model = new ContactModel($db);
            $model->deleteContact((int)$id);
            $this->redirect('/whey_web/admin/contacts');
        }
    }
}