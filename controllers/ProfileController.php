<?php

declare(strict_types=1);

class ProfileController extends Controller
{
    public function show(): void
    {
        $this->requireAuth();

        $userModel = new User();
        $user = $userModel->findById((string) Auth::id());

        if ($user === null) {
            Auth::logout();
            Session::flash('error', 'Phiên đăng nhập không hợp lệ.');
            $this->redirect('/whey_web/login');
        }

        // Đảm bảo tên file view này khớp với file .php trong thư mục views/profile
        $this->view('profile/index', [
            'title' => 'Hồ sơ cá nhân - FITWHEY',
            'user' => $user,
            'error' => Session::flash('error'),
            'success' => Session::flash('success'),
        ]);
    }

    public function update(): void
    {
        $this->requireAuth();

        $userId = (string) Auth::id();
        $userModel = new User();
        $user = $userModel->findById($userId);

        if ($user === null) {
            Session::flash('error', 'Không tìm thấy người dùng.');
            $this->redirect('/whey_web/login');
        }

        $fullName = trim((string) ($_POST['full_name'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $address = trim((string) ($_POST['address'] ?? ''));
        $bio = trim((string) ($_POST['bio'] ?? ''));

        $avatarUrl = (string) ($user['avatar_url'] ?? '');

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->handleAvatarUpload($_FILES['avatar']);
            if ($upload['error'] !== null) {
                Session::flash('error', $upload['error']);
                $this->redirect('/whey_web/profile');
            }
            $avatarUrl = (string) $upload['path'];
        }

        $userModel->updateProfile($userId, [
            'full_name' => $fullName,
            'avatar_url' => $avatarUrl,
            'phone' => $phone,
            'address' => $address,
            'bio' => $bio,
        ]);

        Session::flash('success', 'Cập nhật hồ sơ thành công.');
        $this->redirect('/whey_web/profile');
    }

    private function handleAvatarUpload(array $file): array
    {
        $tmpName = (string) $file['tmp_name'];
        if ((int) $file['size'] > 2 * 1024 * 1024) {
            return ['path' => null, 'error' => 'Avatar tối đa 2MB.'];
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);

        if (!isset($allowed[$mime])) {
            return ['path' => null, 'error' => 'Avatar chỉ hỗ trợ JPG, PNG, WEBP.'];
        }

        // SỬA ĐƯỜNG DẪN: Lưu vào thư mục public để trình duyệt có thể truy cập
        $uploadDir = './public/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'avatar_' . time() . '_' . uniqid() . '.' . $allowed[$mime];
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $target)) {
            return ['path' => 'avatars/' . $fileName, 'error' => null];
        }

        return ['path' => null, 'error' => 'Không thể lưu avatar lên server.'];
    }
}