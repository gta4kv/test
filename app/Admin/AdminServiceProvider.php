<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:48
 */

namespace App\Admin;


use App\Admin\Http\AuthController;
use Useless\Http\Middlewares\Auth;
use Useless\Http\Middlewares\Guest;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return mixed
     */
    public function register()
    {
        // routes constructors are ugly, yep..

        $this->app['route']->add(new Route(
            '/logout',
            'GET',
            AuthController::class . '@actionLogout',
            [
                Auth::class
            ]
        ));


        $this->app['route']->add(new Route(
            '/login',
            ['GET', 'POST'],
            AuthController::class . '@actionAuth',
            [
                Guest::class
            ]
        ));

        $this->app['view']->addModule('Admin', 'admin');
    }
}