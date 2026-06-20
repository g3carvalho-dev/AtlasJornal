<?php

namespace App\Controllers;

use App\Core\StatusNoticia;
use App\Models\Noticia;
use App\Repositories\NoticiaRepository;

class NoticiaController
{
    public function create(): void
    {
        require __DIR__ . '/../Views/noticia/create.php';
    }

    public function minhas(): void
    {
        $redatorId = $_SESSION['usuario_id'] ?? 1;
        $noticias = NoticiaRepository::byRedator($redatorId);
        require __DIR__ . '/../Views/noticia/minhas.php';
    }

    public function edit(string $id): void
    {
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/'));
            exit;
        }
        require __DIR__ . '/../Views/noticia/edit.php';
    }

    public function update(string $id): void
    {
        $noticia = NoticiaRepository::find((int) $id);
        if (!$noticia) {
            header('Location: ' . url('/'));
            exit;
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $secao = trim($_POST['secao'] ?? '');
        $resumo = trim($_POST['resumo'] ?? '');
        $conteudo = trim($_POST['conteudo'] ?? '');

        $errors = [];
        if ($titulo === '') $errors[] = 'O título é obrigatório.';
        if ($categoria === '') $errors[] = 'A categoria é obrigatória.';
        if ($secao === '') $errors[] = 'A seção é obrigatória.';
        if ($resumo === '') $errors[] = 'O resumo é obrigatório.';
        if ($conteudo === '') $errors[] = 'O conteúdo é obrigatório.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . url('/noticia/' . $id . '/editar'));
            exit;
        }

        $noticia->setTitulo($titulo);
        $noticia->setCategoria($categoria);
        $noticia->setSecao($secao);
        $noticia->setResumo($resumo);
        $noticia->setConteudo($conteudo);

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed)) {
                $nomeImagem = 'noticia_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
                $destino = __DIR__ . '/../../public/assets/img/' . $nomeImagem;
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                    $noticia->setImagem($nomeImagem);
                }
            }
        }

        NoticiaRepository::update($noticia);

        $_SESSION['sucesso'] = 'Notícia atualizada com sucesso!';
        header('Location: ' . url('/noticia/minhas'));
        exit;
    }

    public function store(): void
    {
        $titulo = trim($_POST['titulo'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $secao = trim($_POST['secao'] ?? '');
        $resumo = trim($_POST['resumo'] ?? '');
        $conteudo = trim($_POST['conteudo'] ?? '');

        $errors = [];

        if ($titulo === '') {
            $errors[] = 'O título é obrigatório.';
        }
        if ($categoria === '') {
            $errors[] = 'A categoria é obrigatória.';
        }
        if ($secao === '') {
            $errors[] = 'A seção é obrigatória.';
        }
        if ($resumo === '') {
            $errors[] = 'O resumo é obrigatório.';
        }
        if ($conteudo === '') {
            $errors[] = 'O conteúdo é obrigatório.';
        }

        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                $errors[] = 'Formato de imagem inválido. Use JPG, PNG ou WebP.';
            } else {
                $nomeImagem = 'noticia_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
                $destino = __DIR__ . '/../../public/assets/img/' . $nomeImagem;

                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                    $imagem = $nomeImagem;
                } else {
                    $errors[] = 'Erro ao fazer upload da imagem.';
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'titulo' => $titulo,
                'categoria' => $categoria,
                'secao' => $secao,
                'resumo' => $resumo,
                'conteudo' => $conteudo,
            ];
            header('Location: ' . url('/noticia/nova'));
            exit;
        }

        $acao = $_POST['acao'] ?? 'salvar';
        $status = ($acao === 'enviar') ? StatusNoticia::ANALISE : StatusNoticia::RASCUNHO;

        $noticia = new Noticia(
            0,
            1,
            $titulo,
            $resumo,
            $conteudo,
            $imagem,
            $categoria,
            $secao,
            $status,
            new \DateTime()
        );

        NoticiaRepository::create($noticia);

        if ($acao === 'enviar') {
            $_SESSION['sucesso'] = 'Notícia enviada para revisão com sucesso!';
        } else {
            $_SESSION['sucesso'] = 'Rascunho salvo com sucesso!';
        }

        header('Location: ' . url('/'));
        exit;
    }
}
