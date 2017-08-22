<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 19:39
 */

namespace App\Offers\Http;


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
            'method' => json_encode($methodService->findAll())
        ]);
    }
}