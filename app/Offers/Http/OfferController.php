<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 19:39
 */

namespace App\Offers\Http;


use App\Currency\CurrencyService;
use App\Offers\Offer;
use App\Offers\OfferService;
use App\Payment\Method\GroupService;
use App\Payment\MethodService;
use App\Player\Service\PlayerService;
use Useless\Http\Controller;
use Useless\Http\Exceptions\AccessViolationException;
use Useless\Http\Exceptions\NotFoundHttpException;

class OfferController extends Controller
{
    public function actionShow()
    {
        /** @var GroupService $groupService */
        $groupService = app(GroupService::class);

        /** @var MethodService $methodService */
        $methodService = app(MethodService::class);

        return $this->view->render('@offers/list.twig', [
            'groups'               => json_encode($groupService->findAll()),
            'method'               => json_encode($methodService->findAll()),
            'bitcoin'              => apcu_fetch('bitcoin'),
            'offerService'         => app(OfferService::class),
            'playerService'        => app(PlayerService::class),
            'currencyService'      => app(CurrencyService::class),
            'paymentMethodService' => app(MethodService::class)
        ]);
    }

    public function actionCreateOrUpdate($offerId = null)
    {
        /** @var GroupService $groupService */
        $groupService = app(GroupService::class);

        /** @var MethodService $methodService */
        $methodService = app(MethodService::class);

        /** @var CurrencyService $currencyService */
        $currencyService = app(CurrencyService::class);

        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        $offer = new Offer();

        if ($offerId !== null) {
            $offer = $this->checkOffer($offerId);
        }

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->post();

            $this->fillObjectFromPost($offer, $data);

            $validator = $offerService->validate(
                $data, $currencyService->findAll(), $groupService->findAll(), $methodService->findAll()
            );

            if (!$errors = $validator->getErrors()) {
                $offerService->createOrUpdate($offer);

                $this->response->redirect('/dashboard');
            }
        }

        $method = $methodService->findById($offer->getPaymentMethodId());

        return view()->render('@offers/create.twig', [
            'pmGroups'     => $groupService->findAll(),
            'methods_json' => json_encode($methodService->findAllWithGroupsAsKey()),
            'currencies'   => $currencyService->findAll(),
            'bitcoinPrice' => apcu_fetch('bitcoin'),
            'offer'        => $offer,
            'errors'       => $errors,
            'selected'     => [
                'method' => $offer->getPaymentMethodId(),
                'group'  => $method ? $method->getGroupId() : null
            ]
        ]);
    }

    /**
     * @param int $offerId
     * @return Offer
     * @throws AccessViolationException|NotFoundHttpException
     */
    private function checkOffer($offerId)
    {
        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        /** @var Offer $offer */
        if ($offer = $offerService->findById($offerId)) {
            if ($this->player->getId() != $offer->getPlayerId()) {
                throw new AccessViolationException;
            }

            return $offer;
        }

        throw new NotFoundHttpException;
    }

    /**
     * @param Offer $offer
     * @param $data
     */
    private function fillObjectFromPost(Offer &$offer, array $data)
    {
        $offer
            ->setType($data['tradeType'])
            ->setCurrencyId($data['currencyId'])
            ->setPaymentMethodId($data['paymentMethod'])
            ->setMin($data['amountMin'])
            ->setMax($data['amountMax'])
            ->setMargin($data['margin'])
            ->setDisabled(0)
            ->setPlayerId($this->player->getId());
    }

    public function actionDelete($offerId)
    {
        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        $offer = $this->checkOffer($offerId);

        $offerService->delete($offer->getId());

        response()->redirect('/dashboard');
    }

    public function actionDisable($offerId)
    {
        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        $offer = $this->checkOffer($offerId);

        $offer->setDisabled(true);

        $offerService->createOrUpdate($offer);

        response()->redirect('/dashboard');
    }

    public function actionEnable($offerId)
    {
        /** @var OfferService $offerService */
        $offerService = app(OfferService::class);

        $offer = $this->checkOffer($offerId);

        $offer->setDisabled(false);

        $offerService->createOrUpdate($offer);

        response()->redirect('/dashboard');
    }
}