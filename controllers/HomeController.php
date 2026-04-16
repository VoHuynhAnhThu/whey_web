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
        $this->view('public/about', [
            'title' => 'About - FITWHEY',
            'heading' => 'About This Project',
        ]);
    }
}
