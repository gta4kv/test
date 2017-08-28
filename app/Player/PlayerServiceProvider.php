<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:48
 */

namespace App\Player;


use App\Player\Http\AuthController;
use App\Player\Http\DashboardController;
use App\Player\Http\RegistrationController;
use Useless\Http\Middlewares\Auth;
use Useless\Http\Middlewares\Guest;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

/**
 * Class PlayerServiceProvider
 * @package App\Player
 */
class PlayerServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        // routes constructors are ugly, yep..

        \route()->add(new Route(
            '/logout',
            'GET',
            AuthController::class . '@actionLogout', [
                Auth::class
            ]
        ));


        route()->add(new Route(
            '/register',
            ['GET', 'POST'],
            RegistrationController::class . '@actionForm', [
                Guest::class
            ]
        ));

        route()->add(new Route(
            '/login',
            ['GET', 'POST'],
            AuthController::class . '@actionAuth', [
                Guest::class
            ]
        ));

        route()->add(new Route(
            '/dashboard',
            ['GET'],
            DashboardController::class . '@actionList', [Auth::class]
        ));

        view()->addModule('Player', 'player');
    }
}