<?php
declare(strict_types=1);

if (!function_exists('asset')) {
    /**
     * Build a public asset URL based on config/base_url and the public folder.
     */
    function asset(string $path): string
    {
        $config = require __DIR__ . '/../config/app.php';
        $base = rtrim($config['base_url'] ?? '', '/');
        // Normalize path: remove any leading base_url, /public, or /whey_web
        $p = $path;
        // remove base_url if accidentally passed
        $p = preg_replace('#^' . preg_quote($base, '#') . '#', '', $p);
        $p = preg_replace('#^/public#', '', $p);
        $p = preg_replace('#^/whey_web#', '', $p);
        $p = ltrim($p, '/');

        // collapse duplicated uploads segments like uploads/uploads/... -> uploads/...
        while (strpos($p, 'uploads/uploads') !== false) {
            $p = str_replace('uploads/uploads', 'uploads', $p);
        }

        return $base . '/public/' . $p;
    }
}
