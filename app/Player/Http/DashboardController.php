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
use Useless\Http\Controller;

class DashboardController extends Controller
{
    public function actionList()
    {
        return $this->view->render('@admin/dashboard.twig', [
            'offerService'         => app(OfferService::class),
            'playerService'        => app(PlayerService::class),
            'currencyService'      => app(CurrencyService::class),
            'paymentMethodService' => app(MethodService::class),
            'bitcoin'              => apcu_fetch('bitcoin')
        ]);
    }
}