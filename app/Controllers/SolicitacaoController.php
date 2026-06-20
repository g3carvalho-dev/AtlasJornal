<?php

namespace App\Controllers;

use App\Core\StatusSolicitacao;
use App\Repositories\SolicitacaoCargoRepository;
use App\Repositories\UsuarioRepository;

class SolicitacaoController
{
    public function index(): void
    {
        $solicitacoes = SolicitacaoCargoRepository::allWithUser();
        $stats = SolicitacaoCargoRepository::stats();
        $selecionada = null;
        $selecionadaUser = null;

        $solId = $_GET['id'] ?? null;
        if ($solId) {
            $selecionada = SolicitacaoCargoRepository::find((int) $solId);
            if ($selecionada) {
                $selecionadaUser = UsuarioRepository::find($selecionada->getUsuarioId());
            }
        }

        require __DIR__ . '/../Views/solicitacao/index.php';
    }

    public function aprovar(string $id): void
    {
        $sol = SolicitacaoCargoRepository::find((int) $id);
        if (!$sol) {
            header('Location: ' . url('/solicitacoes'));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');
        $adminId = $_SESSION['usuario_id'] ?? 1;

        SolicitacaoCargoRepository::responder((int) $id, StatusSolicitacao::APROVADA, $adminId, $observacao ?: null);

        $usuario = UsuarioRepository::find($sol->getUsuarioId());
        if ($usuario) {
            if ($sol->getCargo()->value === 'REDATOR') {
                UsuarioRepository::updatePermissoes($usuario->getId(), true, $usuario->getPodeRevisar(), $usuario->getIsAdmin());
            } elseif ($sol->getCargo()->value === 'REVISOR') {
                UsuarioRepository::updatePermissoes($usuario->getId(), $usuario->getPodeRedigir(), true, $usuario->getIsAdmin());
            }
        }

        $_SESSION['sucesso'] = 'Solicitação aprovada! Permissões atualizadas.';
        header('Location: ' . url('/solicitacoes'));
        exit;
    }

    public function rejeitar(string $id): void
    {
        $sol = SolicitacaoCargoRepository::find((int) $id);
        if (!$sol) {
            header('Location: ' . url('/solicitacoes'));
            exit;
        }

        $observacao = trim($_POST['observacao'] ?? '');
        $adminId = $_SESSION['usuario_id'] ?? 1;

        SolicitacaoCargoRepository::responder((int) $id, StatusSolicitacao::REJEITADA, $adminId, $observacao ?: null);

        $_SESSION['sucesso'] = 'Solicitação rejeitada.';
        header('Location: ' . url('/solicitacoes'));
        exit;
    }
}
