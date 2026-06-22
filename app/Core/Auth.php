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

    public static function check(): bool
    {
        self::start();
        return !empty($_SESSION['usuario_logado']) && !empty($_SESSION['usuario_id']);
    }

    public static function id(): ?int
    {
        self::start();
        return isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;
    }

    public static function cargo(): string
    {
        self::start();
        return $_SESSION['usuario_cargo'] ?? 'leitor';
    }

    public static function isAdmin(): bool
    {
        return self::cargo() === 'administrador';
    }

    public static function isRevisor(): bool
    {
        return in_array(self::cargo(), ['revisor', 'administrador']);
    }

    public static function isRedator(): bool
    {
        return in_array(self::cargo(), ['redator', 'revisor', 'administrador']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . url('/login'));
            exit;
        }
    }

    public static function requireRedator(): void
    {
        self::requireLogin();
        if (!self::isRedator()) {
            header('Location: ' . url('/'));
            exit;
        }
    }

    public static function requireRevisor(): void
    {
        self::requireLogin();
        if (!self::isRevisor()) {
            header('Location: ' . url('/'));
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: ' . url('/'));
            exit;
        }
    }
}
