<?php

use App\Core\App;

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Helpers.php';
require_once __DIR__ . '/../app/Core/App.php';

$app = new App();
$app->run();
