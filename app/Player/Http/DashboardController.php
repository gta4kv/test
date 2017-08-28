<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 22/08/2017
 * Time: 19:56
 */

namespace App\Player\Http;


use App\Currency\CurrencyService;
use App\Offers\OfferService;
use App\Payment\MethodService;
use App\Player\Service\PlayerService;
use App\Trade\TradeService;
use Useless\Http\Controller;

/**
 * Class DashboardController
 * @package App\Player\Http
 */
class DashboardController extends Controller
{
    /**
     * @return string
     */
    public function actionList()
    {
        return view()->render('@player/dashboard.twig', [
            'bitcoin'              => apcu_fetch('bitcoin'),
            'offerService'         => app(OfferService::class),
            'tradeService'         => app(TradeService::class),
            'playerService'        => app(PlayerService::class),
            'currencyService'      => app(CurrencyService::class),
            'paymentMethodService' => app(MethodService::class)
        ]);
    }
}