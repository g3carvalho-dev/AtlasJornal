<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;
use App\Repositories\SolicitacaoCargoRepository;
use App\Repositories\RevisaoRepository;

class HomeController
{
    public function index(): void
    {
        $hero = NoticiaRepository::bySecao('hero');
        $nacional = NoticiaRepository::bySecao('nacional');
        $internacional = NoticiaRepository::bySecao('internacional');

        $userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
        $userId = $_SESSION['usuario_id'] ?? 0;

        $pendentesRevisao = RevisaoRepository::pendentesCount();
        $meusPendentes = NoticiaRepository::countByRedatorPending($userId);
        $solicitacoesPendentes = SolicitacaoCargoRepository::temPendente($userId) ? 1 : 0;
        $solicitacoesPendentesCount = count(SolicitacaoCargoRepository::pending());

        require __DIR__ . '/../Views/home/app.php';
    }

    public function show(?string $id): void
    {
        if ($id === null) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $noticia = NoticiaRepository::find((int) $id);

        if ($noticia === null) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $autor = \App\Repositories\UsuarioRepository::find($noticia->getRedatorId());
        $relacionadas = NoticiaRepository::bySecao($noticia->getSecao());

        require __DIR__ . '/../Views/noticia/show.php';
    }

    public function busca(): void
    {
        $termo = trim($_GET['q'] ?? '');
        $resultados = [];

        if ($termo !== '') {
            $resultados = NoticiaRepository::search($termo);
        }

        require __DIR__ . '/../Views/home/busca.php';
    }
}
