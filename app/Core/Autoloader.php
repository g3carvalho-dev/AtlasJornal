<?php

namespace App\Core;

class Autoloader
{
    private static array $classMap = [
        'App\\Core\\StatusNoticia' => __DIR__ . '/Enums.php',
        'App\\Core\\AcaoRevisao' => __DIR__ . '/Enums.php',
        'App\\Core\\CargoSolicitado' => __DIR__ . '/Enums.php',
        'App\\Core\\StatusSolicitacao' => __DIR__ . '/Enums.php',
    ];

    public static function register(): void
    {
        spl_autoload_register([self::class, 'load']);
    }

    private static function load(string $class): void
    {
        if (isset(self::$classMap[$class])) {
            require self::$classMap[$class];
            return;
        }

        $prefix = 'App\\';
        $baseDir = __DIR__ . '/../';

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}
