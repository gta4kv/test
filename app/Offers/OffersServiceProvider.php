<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 19:33
 */

namespace App\Offers;

use App\Offers\Http\ListController;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

class OffersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['view']->addModule('Offers', 'offers');

        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        $this->app['route']->add(new Route(
            '/',
            'GET',
            ListController::class . '@actionShow'
        ));
    }
}