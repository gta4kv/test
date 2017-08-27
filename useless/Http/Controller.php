<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 17:41
 */

namespace Useless\Http;

use App\Admin\Admin;
use App\Player\Player;
use App\Player\Service\PlayerService;
use Useless\Application;
use Useless\View\View;

/**
 * Class Controller
 * @package Useless\Http
 */
abstract class Controller
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Player
     */
    protected $player;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = app();

        $this->request = request();

        $this->response = response();

        $this->view = view();

        if ($user = session()->get('user', null)) {
            $this->player = app(PlayerService::class)->findById($user->getId());
        } else {
            $this->player = null;
        }

    }
}