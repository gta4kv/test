<?php

namespace App\Player\Http;

use App\Player\Player;
use App\Player\Service\PlayerService;
use Useless\Http\Controller;

class RegistrationController extends Controller
{
    public function actionForm()
    {
        /** @var PlayerService $service */
        $service = app(PlayerService::class);

        $player = new Player();
        $errors = [];

        if ($this->request->isPost()) {
            $data = request()->post();

            $this->fillObjectFromPost($player, $data);

            $validator = $service->validate($data);

            if ($validator->getErrors()) {
                $errors = $validator->getErrors();
            } else {
                $service->createOrUpdate($player);

                response()->redirect('/login?signupSuccess=1');
            }
        }

        return view()->render('@admin/register.twig', [
            'player' => $player,
            'errors' => $errors
        ]);
    }

    /**
     * @param Player $player
     * @param $data
     */
    private function fillObjectFromPost(Player &$player, $data)
    {
        $player
            ->setFullName($data['full_name'])
            ->setPassword($data['password'])
            ->setEmail($data['email']);
    }
}