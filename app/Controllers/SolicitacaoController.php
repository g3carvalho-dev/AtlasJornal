<?php

namespace App\Controllers;

class SolicitacaoController
{
    public function index(): void
    {
        require __DIR__ . '/../Views/solicitacao/index.php';
    }
}
