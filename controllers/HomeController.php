<?php

declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('public/home', [
            'title' => 'FITWHEY - Home',
            'heading' => 'FITWHEY MVC Skeleton',
        ]);
    }

    public function about(): void
    {
        $settingModel = new Settings();
        $aboutData = $settingModel->getByPage('about');

        $this->view('public/about', [
            'title' => 'About - FITWHEY',
            'heading' => $aboutData['about_title'] ?? 'About us',
            'content' => $aboutData['about_content'] ?? 'Nội dung đang cập nhật...',
            'image' => $aboutData['about_image'] ?? ''
        ]);
    }
}
