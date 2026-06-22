<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Repositories\NoticiaRepository;

class AdminNoticiaController
{
    public function index(): void
    {
        Auth::requireRevisor();
        $noticias = NoticiaRepository::allWithAuthor();
        require __DIR__ . '/../Views/admin/noticias.php';
    }

    public function delete(string $id): void
    {
        Auth::requireAdmin();
        NoticiaRepository::delete((int) $id);
        $_SESSION['sucesso'] = 'Notícia excluída com sucesso!';
        header('Location: ' . url('/admin/noticias'));
        exit;
    }
}
