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
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard - FITWHEY',
            'heading' => 'Admin Dashboard Placeholder',
        ]);
    }

    public function index()
    {
        $allUsers = $this->userModel->getAll();
        
        return $this->view('admin/users/index', [
            'users' => $allUsers,
            'title' => 'Quản lý người dùng'
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($email, $passwordHash, $role);
            header('Location: /whey_web/admin/users/add');
            exit;
        }

        return $this->view('admin/users/add', ['title' => 'Thêm người dùng mới']);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $this->userModel->delete($id);
        }
        header('Location: /whey_web/admin/users');
        exit;
    }

    public function edit() 
    {
        $id = $_GET['id'] ?? '';
        $user = $this->userModel->findById($id);

        if (!$user) {
            header('Location: /admin/users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'role' => $_POST['role'],
                'status' => $_POST['status']
            ];
            $this->userModel->updateAccount($id, $data);
            header('Location: /whey_web/admin/users');
            exit;
        }

        return $this->view('/admin/users/edit', ['user' => $user]);
    }
}