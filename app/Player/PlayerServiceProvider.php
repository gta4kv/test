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

        $this->app['view']->addModule('Player', 'player');
    }
}