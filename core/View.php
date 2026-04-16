<?php

declare(strict_types=1);

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../views/layouts/' . $layout . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("View {$view} not found");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (!file_exists($layoutPath)) {
            echo $content;
            return;
        }

        require $layoutPath;
    }
}
