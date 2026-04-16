<?php

declare(strict_types=1);

class Session
{
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, ?string $message = null): ?string
    {
        $flashKey = '_flash_' . $key;

        if ($message !== null) {
            $_SESSION[$flashKey] = $message;
            return null;
        }

        $value = $_SESSION[$flashKey] ?? null;
        unset($_SESSION[$flashKey]);
        return $value;
    }
}
