<?php

namespace App\Core;

class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function user(): ?array
    {
        self::start();

        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . url('/login'));
            exit;
        }
    }

    public static function canWrite(): bool
    {
        $user = self::user();

        return $user && (
            !empty($user['podeRedigir']) ||
            !empty($user['isAdmin'])
        );
    }

    public static function canReview(): bool
    {
        $user = self::user();

        return $user && (
            !empty($user['podeRevisar']) ||
            !empty($user['isAdmin'])
        );
    }

    public static function isAdmin(): bool
    {
        $user = self::user();

        return $user && !empty($user['isAdmin']);
    }
}
