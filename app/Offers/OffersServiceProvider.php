<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 19:33
 */

namespace App\Offers;

use App\Offers\Http\OfferController;
use Useless\Http\Middlewares\Auth;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

class OffersServiceProvider extends ServiceProvider
{
    public function register()
    {
        view()->addModule('Offers', 'offers');

        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        route()->add(new Route(
            '/',
            'GET',
            OfferController::class . '@actionShow'
        ));

        route()->add(new Route(
            '/offer/create',
            ['GET', 'POST'],
            OfferController::class . '@actionCreateOrUpdate',
            [Auth::class]
        ));

        route()->add(new Route(
            '/offer/:offerId',
            ['GET', 'POST'],
            OfferController::class . '@actionCreateOrUpdate',
            [Auth::class]
        ));

        route()->add(new Route(
            '/offer/disable/:offerId',
            ['GET'],
            OfferController::class . '@actionDisable',
            [Auth::class]
        ));

        route()->add(new Route(
            '/offer/enable/:offerId',
            ['GET'],
            OfferController::class . '@actionEnable',
            [Auth::class]
        ));

        route()->add(new Route(
            '/offer/delete/:offerId',
            ['GET'],
            OfferController::class . '@actionDelete',
            [Auth::class]
        ));
    }
}