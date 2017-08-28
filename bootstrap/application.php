<?php

use App\AppServiceProvider;
use Useless\Database\Database;
use Useless\Database\Engine\EngineInterface as DbEngineInterface;
use Useless\Database\Engine\PdoEngine;
use Useless\Routing\RouteCollection;
use Useless\View\Engine\EngineInterface;
use Useless\View\Engine\TwigTemplateEngine;

date_default_timezone_set('Europe/Tallinn');

$app = new Useless\Application(
    realpath(__DIR__ . '/../')
);

app()->instance('route', new RouteCollection());

app()->instance(EngineInterface::class, new TwigTemplateEngine());
app()->instance(DbEngineInterface::class, $app->make(PdoEngine::class));
app()->instance(Database::class, $app->make(Database::class));

app()->register(AppServiceProvider::class);