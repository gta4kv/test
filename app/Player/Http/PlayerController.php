<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:08
 */

namespace App\Player\Http;


use App\Player\Player;
use App\Player\Service\PlayerService;
use Useless\Http\Controller;
use Useless\Http\Exceptions\NotFoundHttpException;
use Useless\Validator\Validator;

/**
 * Class PlayerController
 * @package App\Player\Http
 */
class PlayerController extends Controller
{
    protected $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new Validator();
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $searchableFields = [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'created_by' => 'Create Admin ID'
        ];

        $operators = [
            '>' => '>',
            '<' => '<',
            '=' => '=',
            '<>' => '<>',
            'like' => '%LIKE%'
        ];

        /* @var PlayerService $player */
        $player = $this->app->make(PlayerService::class);

        $field = $this->request->get('field', 'id');

        // (string) fixing bug when 0 and null treated
        // as the same
        $value = (string)$this->request->get('value', '0');

        $operator = $this->request->get('operator', '>');

        return $this->view->render('@player/list.twig', [
            'players' => $player->searchByAny(
                $field, $value, $operator
            ),
            'defaults' => [
                'field' => $field,
                'value' => $value,
                'operator' => $operator
            ],
            'fields' => $searchableFields,
            'operators' => $operators
        ]);
    }

    public function validate(array $values)
    {
        $validation = $this->validator->setRules([
            ['username', [
                ['required', []],
                ['length', ['max' => 30]]
            ]],
            ['first_name', [
                ['required', []],
                ['length', ['max' => 30]]
            ]],
            ['last_name', [
                ['required', []],
                ['length', ['max' => 30]]
            ]],
            ['birth_date', [
                ['required', []],
                ['date', []]
            ]],
            ['email', [
                ['required', []],
                ['email', []]
            ]],
        ])->validate($values);

        return $validation;
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        /* @var PlayerService $service */
        $service = $this->app->make(PlayerService::class);

        $player = new Player();
        $errors = [];

        if ($this->request->getIsPost()) {
            $data = $this->request->post();

            // we're filling model no matter what
            // so old input values would be available
            // if validation went wrong. since i had no time
            // for a better implementation of flushing old inputs
            $this->fillObjectFromData($player, $data);

            if ($service->findByUsername($player->getUsername()))
            {
                $this->validator->setError('username', ' is already in use');
            }

            $this->validate($data);

            if ($this->validator->getErrors()) {
                $errors = $this->validator->getErrors();
            } else {
                $service->createOrUpdate($player);

                $this->response->redirect('/');
            }
        }

        return $this->getForm($player, $errors);
    }


    private function fillObjectFromData(Player &$object, array $data)
    {
        $object
        ->setUsername($data['username'])
        ->setEmail($data['email'])
        ->setFirstName($data['first_name'])
        ->setLastName($data['last_name'])
        ->setBirthDate($data['birth_date'], true)
        ->setCreatedBy($this->admin->getId());
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionUpdate($id)
    {
        /* @var PlayerService $service */
        $service = $this->app->make(PlayerService::class);

        $player = $service->findById($id);

        $errors = [];

        if (!$player) {
            throw new NotFoundHttpException;
        }

        if ($this->request->getIsPost())
        {
            $data = $this->request->post();

            // no username overriding...
            $data['username'] = $player->getUsername();

            $this->fillObjectFromData($player, $data);

            if (!$this->validate($data)) {
                $errors = $this->validator->getErrors();
            } else {
                $service->createOrUpdate($player);

                $this->response->redirect('/');
            }
        }

        return $this->getForm($player, $errors);
    }

    /**
     * @param $id
     */
    public function actionDelete($id)
    {
        /* @var PlayerService $service */
        $service = $this->app->make(PlayerService::class);

        $player = $service->findById($id);

        if (!$player) {
            throw new NotFoundHttpException;
        }

        $service->delete($id);

        $this->response->redirect('/');
    }

    /**
     * @param Player $player
     * @param null|array
     * @return mixed
     */
    private function getForm(Player $player, $errors = null)
    {
        return $this->view->render('@player/form.twig', compact('player', 'errors'));
    }
}