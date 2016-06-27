<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 11:28
 */

namespace Useless\Routing;

use Useless\Support\ServiceProvider;

/**
 * Class RoutingServiceProvider
 * @package Useless\Routing
 */
class RoutingServiceProvider extends ServiceProvider
{
    /**
     * @return mixed
     */
    public function register()
    {
        $this->registerRouter();
    }

    /**
     *
     */
    public function registerRouter()
    {
        $this->app['router'] = $this->app->share(function ($app) {
            return new Router($app);
        });
    }
}