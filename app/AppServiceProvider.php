<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 11:48
 */

namespace App;

define('APP_ROOT', dirname(__FILE__));

use App\Offers\OffersServiceProvider;
use App\Payment\Bitcoin;
use App\Player\PlayerServiceProvider;
use App\Player\Service\PlayerService;
use App\Trade\TradeServiceProvider;
use Useless\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        view()->addPath(APP_ROOT . '/../resources/views', 'main');

        if ($player = session()->get('user', null)) {
            $player = app(PlayerService::class)->findById($player->getId());
        } else {
            $player = null;
        }

        view()->addGlobal('user', $player);
        view()->addGlobal('request', request());

        app()->register(PlayerServiceProvider::class);
        app()->register(OffersServiceProvider::class);
        app()->register(TradeServiceProvider::class);

        $this->setBitcoinPrice();
    }

    private function setBitcoinPrice()
    {
        if (!apcu_fetch('bitcoin')) {
            apcu_add('bitcoin', (new Bitcoin())->retrieveBitcoinPrice(), 60);
        }
    }
}