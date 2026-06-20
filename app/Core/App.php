<?php

namespace App\Core;

use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\NoticiaController;
use App\Controllers\RevisaoController;
use App\Controllers\SolicitacaoController;

class App
{
    public function run(): void
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');

        $segments = $url === '' ? [] : explode('/', $url);

        $route = $segments[0] ?? 'home';

        switch ($route) {
            case '':
            case 'home':
                require_once __DIR__ . '/../Controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case 'categoria':
                require_once __DIR__ . '/../Controllers/CategoryController.php';
                $controller = new CategoryController();
                $controller->index($segments[1] ?? '');
                break;

            case 'noticia':
                require_once __DIR__ . '/../Controllers/NoticiaController.php';
                $controller = new NoticiaController();

                if (($segments[1] ?? '') === 'nova') {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->store();
                    } else {
                        $controller->create();
                    }
                } elseif (($segments[1] ?? '') === 'minhas') {
                    $controller->minhas();
                } elseif (($segments[2] ?? '') === 'editar' && is_numeric($segments[1] ?? '')) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->update($segments[1]);
                    } else {
                        $controller->edit($segments[1]);
                    }
                } else {
                    require_once __DIR__ . '/../Controllers/HomeController.php';
                    $home = new HomeController();
                    $home->show($segments[1] ?? null);
                }
                break;

            case 'cadastro':
                require_once __DIR__ . '/../Controllers/AuthController.php';
                $controller = new AuthController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->register();
                } else {
                    $controller->cadastro();
                }
                break;

            case 'login':
                require_once __DIR__ . '/../Controllers/AuthController.php';
                $controller = new AuthController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->authenticate();
                } else {
                    $controller->login();
                }
                break;

            case 'logout':
                require_once __DIR__ . '/../Controllers/AuthController.php';
                $controller = new AuthController();
                $controller->logout();
                break;

            case 'revisao':
                require_once __DIR__ . '/../Controllers/RevisaoController.php';
                $controller = new RevisaoController();
                if (($segments[1] ?? '') === 'aprovar' && ($segments[2] ?? '')) {
                    $controller->aprovar($segments[2]);
                } elseif (($segments[1] ?? '') === 'rejeitar' && ($segments[2] ?? '')) {
                    $controller->rejeitar($segments[2]);
                } elseif (($segments[1] ?? '') === 'arquivar' && ($segments[2] ?? '')) {
                    $controller->arquivar($segments[2]);
                } else {
                    $controller->index();
                }
                break;

            case 'solicitacoes':
                require_once __DIR__ . '/../Controllers/SolicitacaoController.php';
                $controller = new SolicitacaoController();
                if (($segments[1] ?? '') === 'aprovar' && ($segments[2] ?? '')) {
                    $controller->aprovar($segments[2]);
                } elseif (($segments[1] ?? '') === 'rejeitar' && ($segments[2] ?? '')) {
                    $controller->rejeitar($segments[2]);
                } else {
                    $controller->index();
                }
                break;

            case 'dashboard':
                require_once __DIR__ . '/../Controllers/DashboardController.php';
                $controller = new DashboardController();
                $controller->index();
                break;

            case 'admin':
                require_once __DIR__ . '/../Controllers/NoticiaController.php';
                $controller = new NoticiaController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                require_once __DIR__ . '/../Views/errors/404.php';
                break;
        }
    }
}
