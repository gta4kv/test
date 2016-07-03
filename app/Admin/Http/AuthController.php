<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:49
 */

namespace App\Admin\Http;

use App\Admin\Admin;
use App\Admin\Service\AdminService;
use Useless\Http\Controller;

class AuthController extends Controller
{
    /**
     * @var string
     */
    private $error = '';

    public function actionAuth()
    {
        if ($this->request->getIsPost()) {
            $this->getAuth($this->request->post('email'), $this->request->post('password'));
        }

        return $this->view->render('@admin/login.twig', [
            'error' => $this->getError()
        ]);
    }

    public function actionLogout()
    {
        $this->request->getSession()->set('admin', '');

        $this->response->redirect('/');
    }

    private function getAuth($email, $password)
    {
        /* @var AdminService $service */
        $service = $this->app->make(AdminService::class);

        /* @var Admin $admin */
        $admin = $service->findByEmail($email);

        if (! $admin || !password_verify($password, $admin->getPassword())) {
            return $this->setError('No admin with such credentials found');
        }

        return $this->setAuth($admin);
    }

    public function setAuth(Admin $admin)
    {
        $this->request->getSession()->set('admin', $admin);

        $this->response->redirect('/');
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}