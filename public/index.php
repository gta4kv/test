<?php
$startTime = microtime();

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/application.php';

/* @var \Useless\Http\Kernel $kernel */
$kernel = $app->make(Useless\Http\Kernel::class);

$response = $kernel->handle();

$response->send();

$endTime = microtime();
$totalTime = $endTime - $startTime;

//var_dump($totalTime);