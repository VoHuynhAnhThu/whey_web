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
        ]);
    }

    public function settings(): void
    {
        // 1. Kiểm tra quyền Admin
        $this->requireRole('admin'); 

        // 2. Khởi tạo Model và truyền biến kết nối Database vào
        // Fix lỗi: Too few arguments to function SettingModel::__construct()
        $db = Database::connection(); 
        $settingModel = new SettingModel($db); 

        // 3. Lấy dữ liệu và định dạng lại để View dễ sử dụng
        $rawSettings = $settingModel->getAllSettings(); 
        $settings = [];
        foreach ($rawSettings as $row) {
            // Giả sử bảng có cột 'setting_key' và 'setting_value'
            $settings[$row['key']] = $row['value'];
        }

        // 4. Đổ dữ liệu ra View
        // Thêm tham số '' ở cuối để báo cho Controller biết: "Đừng dùng layout main nữa!"
        // Thêm dấu nháy đơn trống '' ở tham số thứ 3 để TẮT Layout main
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
            // 1. Lưu các thông tin văn bản trước
            foreach ($_POST as $key => $value) {
            // Chỉ update nếu key bắt đầu bằng site_
            if (str_starts_with($key, 'site_')) {
                $model->updateSetting($key, $value);
            }
}

            // 2. CHỈ xử lý ảnh nếu người dùng có chọn file mới
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                
                $fileTmpPath = $_FILES['site_logo']['tmp_name'];
                $fileName = $_FILES['site_logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Tạo tên file và đường dẫn
                $newFileName = 'logo_' . time() . '.' . $fileExtension;
                $uploadFileDir = './public/uploads/';
                $dest_path = $uploadFileDir . $newFileName;

                // Kiểm tra thư mục tồn tại
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                // Chỉ khi có đầy đủ biến mới gọi hàm này
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $dbPath = '/whey_web/public/uploads/' . $newFileName;
                    $model->updateSetting('site_logo', $dbPath);
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
        
        $contacts = $model->getAllContacts();

        $this->view('admin/contacts/index', [
            'title' => 'Quản lý liên hệ - FITWHEY',
            'contacts' => $contacts
        ], ''); // Tắt layout main để dùng layout admin chuẩn
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
