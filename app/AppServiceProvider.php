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
use App\Player\PlayerServiceProvider;
use Useless\Database\Engine\PdoEngine;
use Useless\Support\ServiceProvider;
use Useless\View\Engine\EngineInterface;
use Useless\View\Engine\TwigTemplateEngine;
use Useless\View\Engine\VanillaTemplateEngine;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(EngineInterface::class, new TwigTemplateEngine());
        $this->app->bind(\Useless\Database\Engine\EngineInterface::class, PdoEngine::class);


        $this->app['view']->addPath(APP_ROOT . '/../resources/views', 'main');
        $this->app['view']->addGlobal('admin', $this->app['request']->getSession()->get('admin'));

        $this->app->register(AdminServiceProvider::class);
        $this->app->register(PlayerServiceProvider::class);
    }
}