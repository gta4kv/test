<?php
namespace App\Player\Http;

use App\Admin\Admin;
use App\Admin\Service\AdminService;
use Useless\Http\Controller;

class RegistrationController extends Controller
{
    public function actionForm()
    {
        return $this->view->render('@admin/register.twig', []);
    }
}