<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:10
 */

namespace App\Player;


use App\Player\Http\PlayerController;
use Useless\Http\Middlewares\Auth;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

class PlayerServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
     */
    public function register()
    {
        $this->app['route']->add(new Route(
            '/',
            'GET',
            PlayerController::class . '@actionList',
            [Auth::class]
        ));

        $this->app['route']->add(new Route(
            '/player/create',
            ['GET', 'POST'],
            PlayerController::class . '@actionCreate',
            [Auth::class]
        ));

        $this->app['route']->add(new Route(
            '/player/update/:id',
            ['GET', 'POST'],
            PlayerController::class . '@actionUpdate',
            [Auth::class]
        ));

        $this->app['route']->add(new Route(
            '/player/delete/:id',
            'GET',
            PlayerController::class . '@actionDelete',
            [Auth::class]
        ));

        $this->app['view']->addModule('Player', 'player');
    }
}