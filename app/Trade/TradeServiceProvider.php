<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:48
 */

namespace App\Trade;


use App\Trade\Http\TradeController;
use Useless\Http\Middlewares\Auth;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

/**
 * Class TradeServiceProvider
 * @package App\Trade
 */
class TradeServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        route()->add(new Route(
            '/trade/create',
            ['POST', 'GET'],
            TradeController::class . '@actionCreate', [Auth::class]
        ));
    }
}