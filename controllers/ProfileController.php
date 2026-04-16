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
            Session::flash('error', 'Phien dang nhap khong hop le.');
            $this->redirect('/whey_web/login');
        }

        $this->view('profile/edit', [
            'title' => 'Ho so ca nhan - FITWHEY',
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
            Session::flash('error', 'Khong tim thay nguoi dung.');
            $this->redirect('/whey_web/login');
        }

        $fullName = trim((string) ($_POST['full_name'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $address = trim((string) ($_POST['address'] ?? ''));
        $bio = trim((string) ($_POST['bio'] ?? ''));

        $avatarUrl = (string) ($user['avatar_url'] ?? '');

        if (isset($_FILES['avatar']) && (int) ($_FILES['avatar']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
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

        Session::flash('success', 'Cap nhat ho so thanh cong.');
        $this->redirect('/whey_web/profile');
    }

    private function handleAvatarUpload(array $file): array
    {
        if ((int) $file['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Tai len avatar that bai.'];
        }

        $tmpName = (string) $file['tmp_name'];
        $size = (int) $file['size'];

        if ($size > 2 * 1024 * 1024) {
            return ['path' => null, 'error' => 'Avatar toi da 2MB.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            return ['path' => null, 'error' => 'Avatar chi ho tro JPG, PNG, WEBP.'];
        }

        $avatarsDir = __DIR__ . '/../uploads/avatars';
        if (!is_dir($avatarsDir)) {
            mkdir($avatarsDir, 0755, true);
        }

        $fileName = Str::uuid() . '.' . $allowed[$mime];
        $target = $avatarsDir . '/' . $fileName;

        if (!move_uploaded_file($tmpName, $target)) {
            return ['path' => null, 'error' => 'Khong the luu avatar len server.'];
        }

        return [
            'path' => '/whey_web/uploads/avatars/' . $fileName,
            'error' => null,
        ];
    }
}
