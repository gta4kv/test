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
        if (request()->isPost()) {
            $this->getAuth(request()->post('email'), request()->post('password'));
        }

        return view()->render('@player/login.twig', [
            'error' => $this->getError()
        ]);
    }

    private function getAuth($email, $password)
    {
        /* @var PlayerService $service */
        $service = app(PlayerService::class);

        /* @var Player $admin */
        $admin = $service->findByEmail($email);

        if (! $admin || !password_verify($password, $admin->getPassword())) {
            return $this->setError('No admin with such credentials found');
        }

        return $this->setAuth($admin);
    }

    public function setAuth(Player $user)
    {
        session()->set('user', $user);

        response()->redirect('/?loginSuccessful=1');
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
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

    public function actionLogout()
    {
        session()->set('user', '');

        response()->redirect('/');
    }

}