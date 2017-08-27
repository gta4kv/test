<?php

namespace App\Payment;

class Bitcoin
{
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