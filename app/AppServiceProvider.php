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
use App\Offers\OffersServiceProvider;
use App\Player\PlayerServiceProvider;
use Useless\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['view']->addPath(APP_ROOT . '/../resources/views', 'main');
        $this->app['view']->addGlobal('user', $this->app['request']->getSession()->get('user'));

        $this->app->register(PlayerServiceProvider::class);
        $this->app->register(OffersServiceProvider::class);
    }
}