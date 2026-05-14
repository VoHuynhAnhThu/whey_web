<?php

declare(strict_types=1);

abstract class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.');
            $this->redirect('/whey_web/login');
        }
    }

    protected function requireGuest(): void
    {
        if (Auth::check()) {
            // Nếu là admin thì về dashboard, nếu là user thì về profile
            if (Auth::isAdmin()) {
                $this->redirect('/whey_web/admin');
            } else {
                $this->redirect('/whey_web/profile');
            }
        }
    }

    protected function requireRole(string $role): void
    {
        $this->requireAuth();

        if (Auth::role() !== $role) {
            http_response_code(403);
            $this->view('errors/403', [
                'title' => '403 Forbidden',
            ]);
            exit;
        }
    }
}