<?php

declare(strict_types=1);

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, string $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, string $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, string $action): void
    {
        $normalizedPath = $this->normalizePath($path);
        $this->routes[$method][$normalizedPath] = $action;
    }

    public function dispatch(string $requestUri, string $requestMethod): void
    {
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';
        $path = $this->normalizePath($path);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');

        if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath)) ?: '/';
        }

        $routesByMethod = $this->routes[$requestMethod] ?? [];

        if (!isset($routesByMethod[$path])) {
            http_response_code(404);
            (new ErrorController())->notFound();
            return;
        }

        [$controllerName, $methodName] = explode('@', $routesByMethod[$path]);

        if (!class_exists($controllerName)) {
            throw new RuntimeException("Controller {$controllerName} not found");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            throw new RuntimeException("Method {$methodName} not found in {$controllerName}");
        }

        $controller->{$methodName}();
    }

    private function normalizePath(string $path): string
    {
        if ($path === '') {
            return '/';
        }

        $path = '/' . trim($path, '/');
        return $path === '//' ? '/' : $path;
    }
}
