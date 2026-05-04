<?php

declare(strict_types=1);

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireRole('admin');

        $this->view('admin/dashboard', [
        'title' => 'Admin Dashboard - FITWHEY',
        'heading' => 'Admin Dashboard Placeholder',
    ], 'admin');
    }

    public function settings(): void
    {
        $this->requireRole('admin'); 
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
        ], '');
    }

    public function updateSettings(): void {
        $this->requireRole('admin');
        $db = Database::connection();
        $model = new SettingModel($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Cập nhật thông tin văn bản
            foreach ($_POST as $key => $value) {
                if (str_starts_with($key, 'site_')) {
                    // Bảo mật: Lọc dữ liệu đầu vào
                    $cleanValue = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                    $model->updateSetting($key, $cleanValue);
                }
            }

            // 2. Xử lý upload Logo (Chỉ lưu tên file)
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

    public function listContacts(): void
    {
        $this->requireRole('admin');
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
        ], '');
    }

    public function updateContactStatus(): void
    {
        $this->requireRole('admin');
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
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $db = Database::connection();
            $model = new ContactModel($db);
            $model->deleteContact((int)$id);
            $this->redirect('/whey_web/admin/contacts');
        }
    }
}