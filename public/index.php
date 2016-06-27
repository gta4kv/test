<?php
$startTime = microtime();
spl_autoload_register(function($className) {
    if (is_file ($path = str_replace('\\', '/', __DIR__ . "/../{$className}.php"))) {
        require_once $path;
    } else {
        throw new Exception("Class [{$className}] not found in path [$path]");
    }
});


$app = require_once __DIR__ . '/../bootstrap/application.php';

$kernel = $app->make(Useless\Http\Kernel::class);

$response = $kernel->handle();

$response->send();

$endTime = microtime();
$totalTime = $endTime - $startTime;

var_dump($totalTime);