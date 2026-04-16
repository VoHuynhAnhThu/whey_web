<?php

declare(strict_types=1);

class Auth
{
    public static function user(): ?array
    {
        $authUser = Session::get('auth_user');

        if (!is_array($authUser) || !isset($authUser['id'])) {
            return null;
        }

        return $authUser;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function login(array $user): void
    {
        Session::set('auth_user', [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);
    }

    public static function logout(): void
    {
        Session::remove('auth_user');
    }

    public static function id(): ?string
    {
        return self::user()['id'] ?? null;
    }

    public static function role(): ?string
    {
        return self::user()['role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }
}
