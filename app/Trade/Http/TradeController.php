<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 28/08/2017
 * Time: 00:29
 */

namespace App\Trade\Http;


use App\Currency\CurrencyService;
use App\Offers\Offer;
use App\Offers\OfferService;
use App\Payment\MethodService;
use App\Player\Service\PlayerService;
use App\Trade\Trade;
use App\Trade\TradeService;
use Useless\Http\Controller;

/**
 * Class TradeController
 * @package App\Trade\Http
 */
class TradeController extends Controller
{
    /**
     * @param int $offerId
     * @return string
     */
    public function actionCreate($offerId)
    {
        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        /** @var TradeService $tradeService */
        $tradeService = app(TradeService::class);

        /** @var Offer $offer */
        $offer = $offerService->findById($offerId);

        $trade = new Trade();
        $errors = [];

        if (request()->isPost()) {
            $data = request()->post();

            $this->fillTradeObject($trade, $data, $offer);

            $validator = $tradeService->validate($data, $offer);

            if (!$errors = $validator->getErrors()) {
                $tradeService->createOrUpdate($trade);
            }
        }

        return view()->render('@trade/create.twig', [
            'offer'                => $offer,
            'trade'                => $trade,
            'errors'               => $errors,
            'bitcoin'              => apcu_fetch('bitcoin'),
            'offerService'         => app(OfferService::class),
            'playerService'        => app(PlayerService::class),
            'currencyService'      => app(CurrencyService::class),
            'paymentMethodService' => app(MethodService::class)
        ]);
    }

    /**
     * @param Trade $trade
     * @param $postData
     * @param Offer $offer
     * @return Trade
     */
    private function fillTradeObject(Trade $trade, $postData, Offer $offer)
    {
        return $trade
            ->setPlayerId($this->player->getId())
            ->setPartnerId($offer->getPlayerId())
            ->setOfferId($offer->getId())
            ->setAmountFiat($postData['amount'])
            ->setAmountBitcoin(100)
            ->setCreatedAt('CURRENT_TIMESTAMP');
    }
}