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
}
