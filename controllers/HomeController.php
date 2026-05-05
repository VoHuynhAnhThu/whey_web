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

    public function faq(): void {
    $questionModel = new Question();
    $this->view('public/faq', [
        'title' => 'Hỏi đáp - FITWHEY',
        'questions' => $questionModel->getAllWithAnswers()
    ]);
}

    public function ask(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $questionModel = new Question();
        
        $currentUser = Auth::user(); 
        
        $data = [
            'title'   => $_POST['title'] ?? '',
            'body'    => $_POST['body'] ?? '',
            'user_id' => $currentUser ? $currentUser['id'] : null 
        ];

        if ($questionModel->create($data)) {
            header('Location: /whey_web/faq?status=success');
            exit;
        }
    }
} 
}
