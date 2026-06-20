<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;
use App\Core\StatusNoticia;

class DashboardController
{
    public function index(): void
    {
        $publicadas = count(NoticiaRepository::byStatus(StatusNoticia::APROVADA));
        $pendentes = count(NoticiaRepository::pendingReview());
        $total = $publicadas + $pendentes;

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}
