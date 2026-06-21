<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;
use App\Repositories\SolicitacaoCargoRepository;
use App\Repositories\UsuarioRepository;
use App\Core\StatusNoticia;

class DashboardController
{
    public function index(): void
    {
        $total = count(NoticiaRepository::byStatus(StatusNoticia::APROVADA))
               + count(NoticiaRepository::byStatus(StatusNoticia::ANALISE))
               + count(NoticiaRepository::byStatus(StatusNoticia::RASCUNHO))
               + count(NoticiaRepository::byStatus(StatusNoticia::ARQUIVADA))
               + count(NoticiaRepository::byStatus(StatusNoticia::REJEITADA));

        $aprovadas = count(NoticiaRepository::byStatus(StatusNoticia::APROVADA));
        $pendentes = count(NoticiaRepository::pendingReview());
        $redatores = UsuarioRepository::countRedatores();
        $revisores = UsuarioRepository::countRevisores();

        $filaRevisao = NoticiaRepository::pendingReviewWithAuthor();
        $solicitacoes = SolicitacaoCargoRepository::pendingWithUser();

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}
