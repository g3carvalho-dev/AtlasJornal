<?php

namespace App\Controllers;

use App\Repositories\NoticiaRepository;

class HomeController
{
    public function index(): void
    {
        $hero = NoticiaRepository::bySecao('hero');
        $nacional = NoticiaRepository::bySecao('nacional');
        $internacional = NoticiaRepository::bySecao('internacional');

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

        $relacionadas = NoticiaRepository::bySecao($noticia->getSecao());

        require __DIR__ . '/../Views/noticia/show.php';
    }
}
