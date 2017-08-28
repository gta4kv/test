<?php
$startTime = microtime();

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../bootstrap/application.php';

/* @var \Useless\Http\Kernel $kernel */
$kernel = app(Useless\Http\Kernel::class);

try {
    $response = $kernel->handle();
} catch (Exception $exception) {
    if (!function_exists('xdebug_enable')) {
        throw $exception;
    }

    echo view()->render('@main/error.twig', [
        'exception' => $exception
    ]);
    die;
}

$response->send();

$endTime = microtime();
//$totalTime = $endTime - $startTime;

//var_dump($totalTime);