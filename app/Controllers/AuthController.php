<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;

class AuthController
{
    public function login(): void
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function cadastro(): void
    {
        require __DIR__ . '/../Views/auth/cadastro.php';
    }

    public function authenticate(): void
    {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        $usuario = UsuarioRepository::findByEmail($email);

        if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
            $_SESSION['errors'] = ['E-mail ou senha inválidos.'];
            $_SESSION['old'] = ['email' => $email];
            header('Location: ' . url('/login'));
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['usuario_logado'] = true;
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_nome'] = $usuario->getNome();
        $_SESSION['usuario_email'] = $usuario->getEmail();
        $_SESSION['usuario_cargo'] = $usuario->getCargo();
        $_SESSION['usuario_foto'] = $usuario->getFoto();

        header('Location: ' . url('/'));
        exit;
    }

    public function register(): void
    {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar_senha'] ?? '';

        $errors = [];

        if ($nome === '') $errors[] = 'O nome é obrigatório.';
        if ($email === '') $errors[] = 'O e-mail é obrigatório.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'E-mail inválido.';
        if (strlen($senha) < 8) $errors[] = 'A senha deve ter pelo menos 8 caracteres.';
        if ($senha !== $confirmar) $errors[] = 'As senhas não conferem.';
        if (UsuarioRepository::findByEmail($email)) $errors[] = 'Este e-mail já está cadastrado.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['nome' => $nome, 'email' => $email];
            header('Location: ' . url('/cadastro'));
            exit;
        }

        $usuario = new Usuario(
            0,
            $nome,
            new \DateTime('2000-01-01'),
            '',
            '',
            $email,
            $senha
        );

        UsuarioRepository::create($usuario);

        $_SESSION['sucesso'] = 'Conta criada com sucesso! Faça login.';
        header('Location: ' . url('/login'));
        exit;
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: ' . url('/'));
        exit;
    }
}
