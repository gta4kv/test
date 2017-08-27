<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 19:39
 */

namespace App\Offers\Http;


use App\Currency\CurrencyService;
use App\Payment\Method\GroupService;
use App\Payment\MethodService;
use Useless\Http\Controller;

class ListController extends Controller
{
    public function actionShow()
    {
        /** @var GroupService $groupService */
        $groupService = $this->app->make(GroupService::class);

        /** @var MethodService $methodService */
        $methodService = $this->app->make(MethodService::class);

        return $this->view->render('@offers/list.twig', [
            'groups' => json_encode($groupService->findAll()),
            'method' => json_encode($methodService->findAll()),

        ]);
    }

    public function actionCreate()
    {
        /** @var GroupService $groupService */
        $groupService = $this->app->make(GroupService::class);

        /** @var MethodService $methodService */
        $methodService = $this->app->make(MethodService::class);

        /** @var CurrencyService $currencyService */
        $currencyService = $this->app->make(CurrencyService::class);

        return $this->view->render('@offers/create.twig', [
            'pmGroups' => $groupService->findAll(),
            'methods_json' => json_encode($methodService->findAllWithGroupsAsKey()),
            'currencies' => $currencyService->findAll()
        ]);
    }
}