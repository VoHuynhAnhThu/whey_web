<?php

declare(strict_types=1);

class ErrorController extends Controller
{
    public function notFound(): void
    {
        $this->view('errors/404', [
            'title' => '404 Not Found',
        ]);
    }
}
