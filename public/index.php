<?php
$startTime = microtime();

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/application.php';

/* @var \Useless\Http\Kernel $kernel */
$kernel = $app->make(Useless\Http\Kernel::class);

try {
    $response = $kernel->handle();
} catch (Exception $exception) {
    if (!function_exists('xdebug_enable')) {
        throw $exception;
    }

    echo $app['view']->render('@main/error.twig', [
        'exception' => $exception
    ]);
    die;
}

$response->send();

$endTime = microtime();
//$totalTime = $endTime - $startTime;

//var_dump($totalTime);