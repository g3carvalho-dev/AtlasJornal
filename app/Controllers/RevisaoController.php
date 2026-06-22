<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\AcaoRevisao;
use App\Core\StatusNoticia;
use App\Models\Revisao;
use App\Repositories\RevisaoRepository;
use App\Repositories\NoticiaRepository;

class RevisaoController
{
    public function index(): void
    {
        Auth::requireLogin();
        $userId = Auth::id();
        $isAdmin = Auth::isAdmin();
        $isRevisor = Auth::isRevisor();

        if ($isAdmin || $isRevisor) {
            $noticias = RevisaoRepository::pendentesEHistorico($userId);

            $ultimaRevisaoPorNoticia = [];
            foreach ($noticias as $row) {
                $ultimaRevisaoPorNoticia[$row['id']] = RevisaoRepository::latestReviewForNoticia((int) $row['id']);
            }

            $noticiaSelecionada = null;
            $autorNoticia = null;
            $podeAprovar = false;

            $noticiaId = $_GET['noticia'] ?? null;
            if ($noticiaId) {
                $noticiaSelecionada = NoticiaRepository::find((int) $noticiaId);
                if ($noticiaSelecionada) {
                    $autorNoticia = \App\Repositories\UsuarioRepository::find($noticiaSelecionada->getRedatorId());
                    $podeAprovar = $isAdmin || ($noticiaSelecionada->getRedatorId() !== $userId);
                }
            }

            require __DIR__ . '/../Views/revisao/index.php';
        } else {
            $minhasNoticias = NoticiaRepository::byRedator($userId);
            $revisoesPorNoticia = [];
            foreach ($minhasNoticias as $noticia) {
                $revisoesPorNoticia[$noticia->getId()] = RevisaoRepository::byNoticia($noticia->getId());
            }
            $noticiaSelecionada = null;
            $revisoesNoticia = [];
            $noticiaId = $_GET['noticia'] ?? null;
            if ($noticiaId) {
                foreach ($minhasNoticias as $n) {
                    if ((int) $n->getId() === (int) $noticiaId) {
                        $noticiaSelecionada = $n;
                        $revisoesNoticia = RevisaoRepository::byNoticia($n->getId());
                        break;
                    }
                }
            }
            require __DIR__ . '/../Views/revisao/minhas.php';
        }
    }

    public function aprovar(string $id): void
    {
        Auth::requireRevisor();
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $revisorId = Auth::id();
        $isAdmin = Auth::isAdmin();

        if ($noticia->getRedatorId() === $revisorId && !$isAdmin) {
            $_SESSION['erro'] = 'Você não pode aprovar seu próprio artigo.';
            header('Location: ' . url('/revisao?noticia=' . $id));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');

        $revisao = new Revisao(0, $revisorId, (int) $id, AcaoRevisao::APROVAR, new \DateTime(), $observacao ?: null);
        RevisaoRepository::create($revisao);

        $noticia->setStatus(StatusNoticia::APROVADA);
        $noticia->setDataPublicacao(new \DateTime());
        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia aprovada com sucesso!';
        header('Location: ' . url('/revisao'));
        exit;
    }

    public function rejeitar(string $id): void
    {
        Auth::requireRevisor();
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $revisorId = Auth::id();
        $isAdmin = Auth::isAdmin();

        if ($noticia->getRedatorId() === $revisorId && !$isAdmin) {
            $_SESSION['erro'] = 'Você não pode rejeitar seu próprio artigo.';
            header('Location: ' . url('/revisao?noticia=' . $id));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');

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
        Auth::requireRevisor();
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/revisao'));
            exit;
        }

        $revisorId = Auth::id();
        $isAdmin = Auth::isAdmin();

        if ($noticia->getRedatorId() === $revisorId && !$isAdmin) {
            $_SESSION['erro'] = 'Você não pode arquivar seu próprio artigo.';
            header('Location: ' . url('/revisao?noticia=' . $id));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');

        $revisao = new Revisao(0, $revisorId, (int) $id, AcaoRevisao::ARQUIVAR, new \DateTime(), $observacao ?: null);
        RevisaoRepository::create($revisao);

        $noticia->setStatus(StatusNoticia::ARQUIVADA);
        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia arquivada.';
        header('Location: ' . url('/revisao'));
        exit;
    }
}
