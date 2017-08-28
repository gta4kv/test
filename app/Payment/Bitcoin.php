<?php

namespace App\Payment;

use App\Currency\Currency;
use App\Offers\Offer;

/**
 * Class Bitcoin
 * @package App\Payment
 */
class Bitcoin
{
    public static function calculate(Currency $currency, Offer $offer)
    {
        $bitcoinPrice = apcu_fetch('bitcoin');

        return ($bitcoinPrice + ($bitcoinPrice * ($offer->getMargin() / 100))) * $currency->getExchangeRate();
    }

    /**
     * @return float
     */
    public function retrieveBitcoinPrice()
    {
        // yeah yeah ugly as fuck
        $response = file_get_contents('https://api.coindesk.com/v1/bpi/currentprice/USD.json');

        if (!$response) {
            return 3000.00;
        }

        $data = json_decode($response, true);

        return $data['bpi']['USD']['rate_float'];
    }
}