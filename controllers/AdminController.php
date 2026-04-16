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
}
