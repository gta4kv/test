<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 17:41
 */

namespace Useless\Http;

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
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();

        $this->request = $this->app['request'];

        $this->response = $this->app['response'];

        $this->view = $this->app['view'];
    }
}