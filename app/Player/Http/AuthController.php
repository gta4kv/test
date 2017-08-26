<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:49
 */

namespace App\Player\Http;

use App\Player\Player;
use App\Player\Service\PlayerService;
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
        $this->request->getSession()->set('user', '');

        $this->response->redirect('/');
    }

    private function getAuth($email, $password)
    {
        /* @var PlayerService $service */
        $service = $this->app->make(PlayerService::class);

        /* @var Player $admin */
        $admin = $service->findByEmail($email);

        if (! $admin || !password_verify($password, $admin->getPassword())) {
            return $this->setError('No admin with such credentials found');
        }

        return $this->setAuth($admin);
    }

    public function setAuth(Player $user)
    {
        $this->request->getSession()->set('user', $user);

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