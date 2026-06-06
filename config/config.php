<?php

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$isLocal = str_contains($host, 'localhost')
|| str_contains($host, '127.0.0.1');

define('APP_ENV', $isLocal ? 'local' : 'production');

if (APP_ENV === 'local') {
    // Em ambiente local (xampp, wamp e outros), a aplicação ainda deverá abrir a pasta do projeto.
    define('BASE_URL', '/AtlasJornal/public');
} else {
    // Em produção, o .htaccess já irá abrir a aplicação em public/
    define('BASE_URL', '');
}
