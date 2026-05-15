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

        $this->view('profile/edit', [
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

        // DEBUG: log upload and payload
        $debugDir = __DIR__ . '/../storage/logs/';
        if (!is_dir($debugDir)) {
            @mkdir($debugDir, 0777, true);
        }
        @file_put_contents($debugDir . 'profile_upload_debug.log', date('c') . " - FILES: " . print_r($_FILES, true) . "\n", FILE_APPEND);

        $payload = [
            'full_name' => $fullName,
            'avatar_url' => $avatarUrl,
            'phone' => $phone,
            'address' => $address,
            'bio' => $bio,
        ];

        @file_put_contents($debugDir . 'profile_upload_debug.log', date('c') . " - PAYLOAD: " . print_r($payload, true) . "\n", FILE_APPEND);

        try {
            $userModel->updateProfile($userId, $payload);
            @file_put_contents($debugDir . 'profile_upload_debug.log', date('c') . " - UPDATE: success\n", FILE_APPEND);
        } catch (Exception $e) {
            @file_put_contents($debugDir . 'profile_upload_debug.log', date('c') . " - UPDATE ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
            Session::flash('error', 'Lỗi khi cập nhật hồ sơ.');
            $this->redirect('/whey_web/profile');
        }

        Session::flash('success', 'Cập nhật hồ sơ thành công.');
        $this->redirect('/whey_web/profile');
    }

    private function handleAvatarUpload(array $file): array
    {
        $tmpName = (string) ($file['tmp_name'] ?? '');

        if (empty($tmpName) || !is_uploaded_file($tmpName)) {
            return ['path' => null, 'error' => 'Không có file được upload.'];
        }

        if ((int) ($file['size'] ?? 0) > 2 * 1024 * 1024) {
            return ['path' => null, 'error' => 'Avatar tối đa 2MB.'];
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);

        if (!isset($allowed[$mime])) {
            return ['path' => null, 'error' => 'Avatar chỉ hỗ trợ JPG, PNG, WEBP.'];
        }

        // Save under project public uploads so web server can serve it
        $uploadDir = __DIR__ . '/../public/uploads/avatars/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            return ['path' => null, 'error' => 'Không thể tạo thư mục lưu ảnh.'];
        }

        $fileName = 'avatar_' . time() . '_' . uniqid() . '.' . $allowed[$mime];
        $target = $uploadDir . $fileName;

        if (!move_uploaded_file($tmpName, $target)) {
            return ['path' => null, 'error' => 'Không thể lưu file lên server.'];
        }

        // Return only filename for DB storage; views will build the public URL via asset()
        return ['path' => $fileName, 'error' => null];
    }
}