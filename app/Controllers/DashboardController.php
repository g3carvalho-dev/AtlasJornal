<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Repositories\NoticiaRepository;
use App\Repositories\SolicitacaoCargoRepository;
use App\Repositories\UsuarioRepository;
use App\Core\StatusNoticia;

class DashboardController
{
    public function index(): void
    {
        Auth::requireRedator();

        $isAdmin = Auth::isAdmin();
        $isRevisor = Auth::isRevisor();
        $userId = Auth::id();

        if ($isAdmin) {
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
        } elseif ($isRevisor) {
            $minhasNoticias = NoticiaRepository::byRedator($userId);
            $total = count($minhasNoticias);
            $aprovadas = count(array_filter($minhasNoticias, fn($n) => $n->getStatus() === StatusNoticia::APROVADA));
            $pendentes = count(NoticiaRepository::pendingReview());

            $filaRevisao = NoticiaRepository::pendingReviewWithAuthor();
            $solicitacoes = [];
        } else {
            $minhasNoticias = NoticiaRepository::byRedator($userId);
            $total = count($minhasNoticias);
            $aprovadas = count(array_filter($minhasNoticias, fn($n) => $n->getStatus() === StatusNoticia::APROVADA));
            $pendentes = NoticiaRepository::countByRedatorPending($userId);

            $filaRevisao = NoticiaRepository::pendingByRedatorWithAuthor($userId);
            $solicitacoes = [];
        }

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}
