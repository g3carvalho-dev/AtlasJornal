<?php

namespace App\Controllers;

use App\Core\CargoSolicitado;
use App\Repositories\UsuarioRepository;
use App\Repositories\NoticiaRepository;
use App\Repositories\RevisaoRepository;
use App\Repositories\SolicitacaoCargoRepository;

class ProfileController
{
    public function index(): void
    {
        $userId = $_SESSION['usuario_id'] ?? null;
        if (!$userId) {
            header('Location: ' . url('/login'));
            exit;
        }

        $usuario = UsuarioRepository::find((int) $userId);
        if (!$usuario) {
            header('Location: ' . url('/logout'));
            exit;
        }

        $sucesso = $_SESSION['sucesso'] ?? null;
        unset($_SESSION['sucesso']);

        $erro = $_SESSION['erro'] ?? null;
        unset($_SESSION['erro']);

        $minhasNoticias = [];
        $revisoesFeitas = [];

        if ($usuario->getPodeRedigir() || $usuario->getIsAdmin()) {
            $minhasNoticias = NoticiaRepository::byRedator($usuario->getId());
        }

        if ($usuario->getPodeRevisar() || $usuario->getIsAdmin()) {
            $revisoesFeitas = RevisaoRepository::revisadasByRevisor($usuario->getId());
        }

        $temPendente = SolicitacaoCargoRepository::temPendente($usuario->getId());
        $solicitacoes = SolicitacaoCargoRepository::byUsuarioWithAdmin($usuario->getId());

        require __DIR__ . '/../Views/profile/index.php';
    }

    public function update(): void
    {
        $userId = $_SESSION['usuario_id'] ?? null;
        if (!$userId) {
            header('Location: ' . url('/login'));
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $nascimento = $_POST['nascimento'] ?? '';
        $formacao = trim($_POST['formacao'] ?? '');
        $assinatura = trim($_POST['assinatura'] ?? '');

        if ($nome === '' || $email === '' || $nascimento === '') {
            $_SESSION['erro'] = 'Nome, email e data de nascimento são obrigatórios.';
            header('Location: ' . url('/perfil'));
            exit;
        }

        UsuarioRepository::updateProfile((int) $userId, $nome, $email, $nascimento, $formacao, $assinatura);

        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;

        $_SESSION['sucesso'] = 'Perfil atualizado com sucesso!';
        header('Location: ' . url('/perfil'));
        exit;
    }

    public function solicitar(): void
    {
        $userId = $_SESSION['usuario_id'] ?? null;
        if (!$userId) {
            header('Location: ' . url('/login'));
            exit;
        }

        $usuario = UsuarioRepository::find((int) $userId);
        if (!$usuario) {
            header('Location: ' . url('/logout'));
            exit;
        }

        if (SolicitacaoCargoRepository::temPendente((int) $userId)) {
            $_SESSION['erro'] = 'Você já possui uma solicitação pendente.';
            header('Location: ' . url('/perfil'));
            exit;
        }

        if ($usuario->getPodeRevisar() || $usuario->getIsAdmin()) {
            $_SESSION['erro'] = 'Você já possui o cargo máximo disponível.';
            header('Location: ' . url('/perfil'));
            exit;
        }

        if ($usuario->getFormacao() === '' || $usuario->getAssinatura() === '') {
            $_SESSION['erro'] = 'Preencha formação e assinatura antes de solicitar um cargo.';
            header('Location: ' . url('/perfil'));
            exit;
        }

        if ($usuario->getPodeRedigir()) {
            $cargo = CargoSolicitado::REVISOR;
        } else {
            $cargo = CargoSolicitado::REDATOR;
        }

        SolicitacaoCargoRepository::create((int) $userId, $cargo);

        $_SESSION['sucesso'] = 'Solicitação enviada! Aguarde a aprovação de um administrador.';
        header('Location: ' . url('/perfil'));
        exit;
    }
}
