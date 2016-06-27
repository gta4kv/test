<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:48
 */

namespace App\Admin;


use App\Admin\Http\AdminController;
use Useless\Routing\Route;
use Useless\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return mixed
     */
    public function register()
    {
        $this->app['route']->add(new Route(
            '/:id/:name',
            ['GET', 'POST'],
            AdminController::class . '@actionAuth'
        ));
    }
}