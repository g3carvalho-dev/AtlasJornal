<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;

class AdminNoticiaController
{
    public function index(): void
    {
        if (($_SESSION['usuario_cargo'] ?? '') !== 'administrador') {
            header('Location: ' . url('/'));
            exit;
        }

        $noticias = NoticiaRepository::allWithAuthor();

        require __DIR__ . '/../Views/admin/noticias.php';
    }

    public function delete(string $id): void
    {
        if (($_SESSION['usuario_cargo'] ?? '') !== 'administrador') {
            header('Location: ' . url('/'));
            exit;
        }

        NoticiaRepository::delete((int) $id);

        $_SESSION['sucesso'] = 'Notícia excluída com sucesso!';
        header('Location: ' . url('/admin/noticias'));
        exit;
    }
}
