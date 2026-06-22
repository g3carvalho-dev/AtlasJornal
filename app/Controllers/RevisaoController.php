<?php

namespace App\Controllers;

use App\Core\AcaoRevisao;
use App\Core\StatusNoticia;
use App\Models\Revisao;
use App\Repositories\RevisaoRepository;
use App\Repositories\NoticiaRepository;

class RevisaoController
{
    public function index(): void
    {
        $userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
        $userId = $_SESSION['usuario_id'] ?? 0;
        $isRevisorOuAdmin = in_array($userCargo, ['revisor', 'administrador']);

        if ($isRevisorOuAdmin) {
            $noticias = RevisaoRepository::pendingWithAuthor();
        } else {
            $noticias = NoticiaRepository::pendingByRedatorWithAuthor($userId);
        }

        $noticiaSelecionada = null;
        $autorNoticia = null;
        $podeAprovar = false;

        $noticiaId = $_GET['noticia'] ?? null;
        if ($noticiaId) {
            $noticiaSelecionada = NoticiaRepository::find((int) $noticiaId);
            if ($noticiaSelecionada) {
                $autorNoticia = \App\Repositories\UsuarioRepository::find($noticiaSelecionada->getRedatorId());
                $revisorId = $_SESSION['usuario_id'] ?? 0;
                $isAdmin = ($_SESSION['usuario_cargo'] ?? '') === 'administrador';
                $podeAprovar = $isAdmin || ($noticiaSelecionada->getRedatorId() !== $revisorId);
            }
        }

        require __DIR__ . '/../Views/revisao/index.php';
    }

    public function aprovar(string $id): void
    {
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $revisorId = $_SESSION['usuario_id'] ?? 0;
        $isAdmin = ($_SESSION['usuario_cargo'] ?? '') === 'administrador';

        if ($noticia->getRedatorId() === $revisorId && !$isAdmin) {
            $_SESSION['erro'] = 'Você não pode aprovar seu próprio artigo.';
            header('Location: ' . url('/revisao?noticia=' . $id));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');

        $revisao = new Revisao(0, $revisorId, (int) $id, AcaoRevisao::APROVAR, new \DateTime(), $observacao ?: null);
        RevisaoRepository::create($revisao);

        $noticia->setStatus(StatusNoticia::APROVADA);
        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia aprovada com sucesso!';
        header('Location: ' . url('/revisao'));
        exit;
    }

    public function rejeitar(string $id): void
    {
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');
        $revisorId = $_SESSION['usuario_id'] ?? 1;

        $revisao = new Revisao(0, $revisorId, (int) $id, AcaoRevisao::REJEITAR, new \DateTime(), $observacao ?: null);
        RevisaoRepository::create($revisao);

        $noticia->setStatus(StatusNoticia::REJEITADA);
        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia rejeitada.';
        header('Location: ' . url('/revisao'));
        exit;
    }

    public function arquivar(string $id): void
    {
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');
        $revisorId = $_SESSION['usuario_id'] ?? 1;

        $revisao = new Revisao(0, $revisorId, (int) $id, AcaoRevisao::ARQUIVAR, new \DateTime(), $observacao ?: null);
        RevisaoRepository::create($revisao);

        $noticia->setStatus(StatusNoticia::ARQUIVADA);
        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia arquivada.';
        header('Location: ' . url('/revisao'));
        exit;
    }
}
