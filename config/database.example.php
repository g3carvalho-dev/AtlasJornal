<?php

if (!defined('APP_ENV')) {
    require __DIR__ . '/config.php';
}

if (APP_ENV === 'local') {
    return [
        'host' => 'localhost',
        'database' => 'jornal_atlasdb',
        'user' => 'root',
        'password' => '',
    ];
}

// Insira as credenciais do banco de dados do seu serviço de hospedagem aqui.
return [
    'host' => 'xxxxxxxxxxxx',
    'database' => 'xxxxxxxxxxxxx',
    'user' => 'xxxxxxxxxxxxx',
    'password' => 'xxxxxxxxxxxxx',
];