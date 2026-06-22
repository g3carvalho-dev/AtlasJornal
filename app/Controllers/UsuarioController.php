<?php

namespace App\Controllers;

use App\Repositories\UsuarioRepository;
use App\Repositories\NoticiaRepository;
use App\Repositories\RevisaoRepository;

class UsuarioController
{
    public function index(): void
    {
        if (($_SESSION['usuario_cargo'] ?? '') !== 'administrador') {
            header('Location: ' . url('/'));
            exit;
        }

        $usuarios = UsuarioRepository::findAll();
        $stats = [];

        foreach ($usuarios as $u) {
            $stats[$u->getId()] = [
                'noticias' => NoticiaRepository::countByRedator($u->getId()),
                'revisoes' => RevisaoRepository::countByRevisor($u->getId()),
            ];
        }

        $sucesso = $_SESSION['sucesso'] ?? null;
        unset($_SESSION['sucesso']);

        require __DIR__ . '/../Views/usuarios/index.php';
    }

    public function delete(string $id): void
    {
        if (($_SESSION['usuario_cargo'] ?? '') !== 'administrador') {
            header('Location: ' . url('/'));
            exit;
        }

        $currentUser = $_SESSION['usuario_id'] ?? 0;

        if ((int) $id === (int) $currentUser) {
            $_SESSION['erro'] = 'Você não pode excluir sua própria conta.';
            header('Location: ' . url('/admin/usuarios'));
            exit;
        }

        $usuario = UsuarioRepository::find((int) $id);
        if (!$usuario) {
            header('Location: ' . url('/admin/usuarios'));
            exit;
        }

        UsuarioRepository::delete((int) $id);

        $_SESSION['sucesso'] = 'Usuário "' . $usuario->getNome() . '" excluído com sucesso.';
        header('Location: ' . url('/admin/usuarios'));
        exit;
    }
}
