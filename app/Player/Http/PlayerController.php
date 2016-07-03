<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:08
 */

namespace App\Player\Http;


use App\Player\Service\PlayerService;
use Useless\Http\Controller;

class PlayerController extends Controller
{
    public function actionList()
    {
        /* @var PlayerService $player */
        $player = $this->app->make(PlayerService::class);

        return $this->view->render('@player/list.twig', [
            'players' => $player->findAll()
        ]);
    }

    public function actionCreate()
    {

    }

    public function actionUpdate($id)
    {

    }

    public function actionDelete($id)
    {

    }
}