<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function showRegister(): void
    {
        $this->requireGuest();

        $this->view('auth/register', [
            'title' => 'Dang ky - FITWHEY',
            'error' => Session::flash('error'),
            'success' => Session::flash('success'),
            'old' => Session::get('old_register', []),
        ]);

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
            Session::flash('error', 'Email khong hop le.');
            $this->redirect('/whey_web/register');
        }

        if (strlen($password) < 6) {
            Session::flash('error', 'Mat khau phai co it nhat 6 ky tu.');
            $this->redirect('/whey_web/register');
        }

        if ($password !== $confirmPassword) {
            Session::flash('error', 'Xac nhan mat khau khong trung khop.');
            $this->redirect('/whey_web/register');
        }

        $userModel = new User();
        $existingUser = $userModel->findByEmail($email);

        if ($existingUser !== null) {
            Session::flash('error', 'Email da duoc su dung.');
            $this->redirect('/whey_web/register');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $userModel->create($email, $passwordHash);

        $newUser = $userModel->findById($userId);
        if ($newUser === null) {
            Session::flash('error', 'Khong tao duoc tai khoan. Thu lai.');
            $this->redirect('/whey_web/register');
        }

        Auth::login($newUser);
        Session::remove('old_register');
        Session::flash('success', 'Dang ky thanh cong. Chao mung ban den voi FITWHEY!');
        $this->redirect('/whey_web/profile');
    }

    public function showLogin(): void
    {
        $this->requireGuest();

        $this->view('auth/login', [
            'title' => 'Dang nhap - FITWHEY',
            'error' => Session::flash('error'),
            'success' => Session::flash('success'),
            'old' => Session::get('old_login', []),
        ]);

        Session::remove('old_login');
    }

    public function login(): void
    {
        $this->requireGuest();

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        Session::set('old_login', ['email' => $email]);

        if ($email === '' || $password === '') {
            Session::flash('error', 'Vui long nhap day du email va mat khau.');
            $this->redirect('/whey_web/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user === null || !password_verify($password, $user['password'])) {
            Session::flash('error', 'Thong tin dang nhap khong dung.');
            $this->redirect('/whey_web/login');
        }

        if (($user['status'] ?? 'active') !== 'active') {
            Session::flash('error', 'Tai khoan cua ban dang bi khoa.');
            $this->redirect('/whey_web/login');
        }

        Auth::login($user);
        Session::remove('old_login');
        Session::flash('success', 'Dang nhap thanh cong.');
        $this->redirect('/whey_web/profile');
    }

    public function logout(): void
    {
        $this->requireAuth();

        Auth::logout();
        Session::flash('success', 'Ban da dang xuat.');
        $this->redirect('/whey_web/login');
    }
}
