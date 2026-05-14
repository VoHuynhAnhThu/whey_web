<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function showRegister(): void
    {
        $this->requireGuest();

        $this->view('auth/register', [
            'title' => 'Đăng ký - FITWHEY',
            'error' => Session::flash('error'),
            'success' => Session::flash('success'),
            'old' => Session::get('old_register', []),
        ], 'auth');

        Session::remove('old_register');
    }

    public function register(): void
    {
        $this->requireGuest();

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        Session::set('old_register', ['email' => $email]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Email không hợp lệ.');
            $this->redirect('/whey_web/register');
        }

        if (strlen($password) < 6) {
            Session::flash('error', 'Mật khẩu phải có ít nhất 6 ký tự.');
            $this->redirect('/whey_web/register');
        }

        if ($password !== $confirmPassword) {
            Session::flash('error', 'Xác nhận mật khẩu không trùng khớp.');
            $this->redirect('/whey_web/register');
        }

        $userModel = new User();
        $existingUser = $userModel->findByEmail($email);

        if ($existingUser !== null) {
            Session::flash('error', 'Email đã được sử dụng.');
            $this->redirect('/whey_web/register');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $userModel->create($email, $passwordHash); // Mặc định là member

        $newUser = $userModel->findById($userId);
        if ($newUser === null) {
            Session::flash('error', 'Không tạo được tài khoản. Thử lại.');
            $this->redirect('/whey_web/register');
        }

        Auth::login($newUser);
        Session::remove('old_register');
        Session::flash('success', 'Đăng ký thành công. Chào mừng bạn đến với FITWHEY!');
        
        // Luôn chuyển về profile sau khi đăng ký mới vì mặc định là member
        $this->redirect('/whey_web/profile');
    }

    public function showLogin(): void
    {
        $this->requireGuest();

        $this->view('auth/login', [
            'title' => 'Đăng nhập - FITWHEY',
            'error' => Session::flash('error'),
            'success' => Session::flash('success'),
            'old' => Session::get('old_login', []),
        ], 'auth');

        Session::remove('old_login');
    }

    public function login(): void
    {
        $this->requireGuest();

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        Session::set('old_login', ['email' => $email]);

        if ($email === '' || $password === '') {
            Session::flash('error', 'Vui lòng nhập đầy đủ email và mật khẩu.');
            $this->redirect('/whey_web/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user === null || !password_verify($password, $user['password'])) {
            Session::flash('error', 'Thông tin đăng nhập không đúng.');
            $this->redirect('/whey_web/login');
        }

        if (($user['status'] ?? 'active') !== 'active') {
            Session::flash('error', 'Tài khoản của bạn đang bị khóa.');
            $this->redirect('/whey_web/login');
        }

        Auth::login($user);
        Session::remove('old_login');
        Session::flash('success', 'Đăng nhập thành công.');

        // FIX: Phân quyền chuyển hướng tại đây
        if ($user['role'] === 'admin') {
            $this->redirect('/whey_web/admin');
        } else {
            $this->redirect('/whey_web/profile');
        }
    }

    public function logout(): void
    {
        $this->requireAuth();

        Auth::logout();
        Session::flash('success', 'Bạn đã đăng xuất.');
        $this->redirect('/whey_web/login');
    }
}