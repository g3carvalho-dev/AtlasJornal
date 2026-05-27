<?php

namespace App\Core;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\NoticiaController;

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

            case 'noticia':
                require_once __DIR__ . '/../Controllers/HomeController.php';
                $controller = new HomeController();
                $id = $segments[1] ?? null;
                $controller->show($id);
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
