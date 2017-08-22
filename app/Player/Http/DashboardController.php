<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 22/08/2017
 * Time: 19:56
 */

namespace App\Player\Http;


use Useless\Http\Controller;

class DashboardController extends Controller
{
    public function actionList()
    {
        return $this->view->render('@admin/dashboard.twig', []);
    }
}