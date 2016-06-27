<?php

use Useless\Routing\RouteCollection;

$app = new Useless\Application(
    realpath(__DIR__ . '/../')
);

$app['database'] = $app->share(function ($app) {
    return new Useless\Database\Database($app->make(\Useless\Database\Engine\EngineInterface::class), $app);
});


$app->instance('route', new RouteCollection());

$app->register(\App\AppServiceProvider::class);

return $app;