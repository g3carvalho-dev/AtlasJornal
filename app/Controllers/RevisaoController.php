<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;

class RevisaoController
{
    public function index(): void
    {
        $noticias = NoticiaRepository::pendingReview();
        require __DIR__ . '/../Views/revisao/index.php';
    }
}
