<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Enums.php';
require_once __DIR__ . '/../app/Core/Helpers.php';
require_once __DIR__ . '/../app/Core/Autoloader.php';

App\Core\Autoloader::register();

use App\Core\App;

$app = new App();
$app->run();
