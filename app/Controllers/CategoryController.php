<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;

class CategoryController
{
    public function index(string $nome): void
    {
        $categoriaAtual = urldecode($nome);
        $noticias = NoticiaRepository::byCategoria($categoriaAtual);
        require __DIR__ . '/../Views/home/categoria.php';
    }
}
