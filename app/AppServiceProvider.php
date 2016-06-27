<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 11:48
 */

namespace App;

define('APP_ROOT', dirname(__FILE__));

use App\Admin\AdminServiceProvider;
use Useless\Database\Engine\PdoEngine;
use Useless\Support\ServiceProvider;
use Useless\View\Engine\EngineInterface;
use Useless\View\Engine\VanillaTemplateEngine;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AdminServiceProvider::class);

        $this->app->bind(EngineInterface::class, VanillaTemplateEngine::class);
        $this->app->bind(\Useless\Database\Engine\EngineInterface::class, PdoEngine::class);

        $this->registerRoutes();
    }

    public function registerRoutes()
    {

    }
}