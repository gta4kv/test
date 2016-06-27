<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:49
 */

namespace App\Admin\Http;

use App\Admin\Admin;
use Useless\Http\Controller;

class AdminController extends Controller
{

    public function actionAuth($id, $name)
    {
        $user = $this->app->make(Admin::class);

        $user = $user->findByEmailAndPassword('admin@admin.com', '$2y$10$DWfNHh/JFX1TwdIzuDefru6OAkKMI525ADN7011rpEmcE2g2C181e');

        return $this->app['view']->render('admin::index', [
            'user' => $user
        ]);
    }
}