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

    // ================= DASHBOARD =================
    
    public function index(): void
    {
        // Gọi thẳng vào hàm dashboard để tránh lỗi "Method index not found"
        $this->dashboard();
    }

    public function dashboard(): void
    {
        // Lấy ID của người đang đăng nhập
        $adminId = (string) Auth::id();
        $currentAdmin = $this->userModel->findById($adminId);

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - FITWHEY',
            'admin' => $currentAdmin,
        ], 'admin');
    }

    // ================= QUẢN LÝ NGƯỜI DÙNG =================

    public function users(): void
    {
        $allUsers = $this->userModel->getAll();
        
        // Đã thêm tham số 'admin' để load đúng giao diện sidebar
        $this->view('admin/users/index', [
            'users' => $allUsers,
            'title' => 'Quản lý người dùng - FITWHEY'
        ], 'admin'); 
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($email, $passwordHash, $role);
            $this->redirect('/whey_web/admin/users');
        }

        $this->view('admin/users/add', [
            'title' => 'Thêm người dùng mới - FITWHEY'
        ], 'admin');
    }

    public function edit(): void 
    {
        $id = $_GET['id'] ?? '';
        $user = $this->userModel->findById($id);

        if (!$user) {
            $this->redirect('/whey_web/admin/users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->userModel->updateAccount($id, $data);
            $this->redirect('/whey_web/admin/users');
        }

        $this->view('admin/users/edit', [
            'title' => 'Sửa thông tin người dùng - FITWHEY',
            'user' => $user
        ], 'admin');
    }

    public function delete(): void
    {
        $id = $_GET['id'] ?? '';
        $currentAdminId = (string) Auth::id();

        if (empty($id)) {
            $this->redirect('/whey_web/admin/users');
        }

        // Ngăn không cho admin tự xóa chính mình
        if ($id === $currentAdminId) {
            $this->redirect('/whey_web/admin/users?error=self_delete');
        }

        $this->userModel->delete($id);
        $this->redirect('/whey_web/admin/users?status=deleted');
    }

    // ================= CÀI ĐẶT HỆ THỐNG & GIỚI THIỆU =================

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

    public function editAbout(): void
    {
        $db = Database::connection();
        $settingModel = new SettingModel($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cập nhật nội dung Text
            $settingsData = $_POST['settings'] ?? [];
            foreach ($settingsData as $key => $value) {
                $cleanValue = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                $settingModel->updateSetting($key, $cleanValue);
            }

            // Xử lý Upload Ảnh Minh Họa
            if (isset($_FILES['about_image_file']) && $_FILES['about_image_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['about_image_file']['tmp_name'];
                $fileName = $_FILES['about_image_file']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'about_' . time() . '.' . $fileExtension;
                    $uploadFileDir = './public/uploads/';
                    $dest_path = $uploadFileDir . $newFileName;

                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $settingModel->updateSetting('about_image', $newFileName);
                    }
                }
            }

            $this->redirect('/whey_web/admin/settings/about?status=success');
        }

        $rawSettings = $settingModel->getAllSettings();
        $aboutData = [];
        foreach ($rawSettings as $row) {
            if (str_starts_with($row['key'], 'about_')) {
                $aboutData[$row['key']] = htmlspecialchars_decode($row['value'], ENT_QUOTES);
            }
        }

        $this->view('admin/settings/about', [
            'title' => 'Quản lý trang Giới thiệu - FITWHEY',
            'about' => $aboutData
        ], 'admin');
    }

    // ================= QUẢN LÝ LIÊN HỆ =================

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

    // ================= QUẢN LÝ FAQs =================

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
                'user_id' => Auth::id(),
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

    public function createFaqForm(): void 
    {
        $this->view('admin/faqs/create', [
            'title' => 'Thêm câu hỏi mới (FAQ)'
        ], 'admin');
    }

    // Xử lý lưu câu hỏi (và cả câu trả lời nếu có) vào Database
    public function storeFaq(): void 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questionModel = new Question();
            $answerModel = new Answer();

            $title = trim($_POST['title'] ?? '');
            $body = trim($_POST['body'] ?? '');
            $answerBody = trim($_POST['answer_body'] ?? '');

            if (!empty($title)) {
                // LẤY ID NGƯỜI ĐĂNG NHẬP (Lưu ý: Đảm bảo biến session của bạn tên là 'user_id')
                $currentUserId = Auth::id();

                // 1. Tạo câu hỏi và truyền user_id vào
                $questionId = $questionModel->create([
                    'user_id' => $currentUserId, 
                    'title'   => $title,
                    'body'    => $body
                ]);

                // 2. Lưu câu trả lời (nếu có)
                if (!empty($answerBody) && $questionId) {
                    $answerModel->create([
                        'question_id' => $questionId,
                        'user_id'     => $currentUserId, // Admin là người trả lời
                        'body'        => $answerBody
                    ]);
                }
            }
            $this->redirect('/whey_web/admin/faqs?status=created');
        }
    }

    // Xóa câu hỏi (FAQ)
    public function deleteFaq(): void 
    {
        $id = $_GET['id'] ?? '';
        
        // 1. Kiểm tra xem có nhận được ID không
        if (empty($id)) {
            die("LỖI: Không nhận được ID trên đường dẫn (URL).");
        }

        try {
            $questionModel = new Question();
            
            // 2. Thực hiện xóa và kiểm tra kết quả
            $result = $questionModel->delete($id);
            
            if ($result) {
                // Nếu xóa thành công thì mới chuyển hướng
                $this->redirect('/whey_web/admin/faqs?status=deleted');
            } else {
                die("LỖI: Lệnh xóa chạy nhưng không có dòng nào trong Database bị xóa. (Có thể ID {$id} không tồn tại).");
            }
            
        } catch (\PDOException $e) {
            // 3. In ra lỗi nếu câu lệnh SQL bị sai
            die("LỖI SQL: " . $e->getMessage());
        } catch (\Throwable $th) {
            // In ra lỗi nếu sai tên biến (ví dụ: dùng $this->db nhưng thực tế là $this->conn)
            die("LỖI PHP: " . $th->getMessage());
        }
    }
}

